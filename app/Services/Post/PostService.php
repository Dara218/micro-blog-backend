<?php

namespace App\Services\Post;

use App\Enums\MediaType;
use App\Interfaces\{
    PostInterface,
    PostMediaInterface,
    UserInterface,
};
use App\Services\Common\StorageService;
use FFMpeg\FFMpeg;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\{
    Request,
    UploadedFile,
};
use Illuminate\Support\Arr;

class PostService
{
    /**
     * PostInterface instance.
     *
     * @var \App\Interfaces\PostInterface $postInterface
     */
    protected PostInterface $postInterface;

    /**
     * PostMediaInterface instance.
     *
     * @var \App\Interfaces\PostMediaInterface $postMediaInterface
     */
    protected PostMediaInterface $postMediaInterface;

    /**
     * UserInterface instance.
     *
     * @var \App\Interfaces\UserInterface $userInterface
     */
    protected UserInterface $userInterface;

    /**
     * StorageService instance.
     *
     * @var \App\Services\Common\StorageService $storageService
     */
    protected StorageService $storageService;

    /**
     * Setup the service.
     *
     * @param \App\Interfaces\PostInterface $postInterface
     * @param \App\Interfaces\UserInterface $userInterface
     * @param \App\Interfaces\PostMediaInterface $postMediaInterface
     */
    public function __construct(
        PostInterface $postInterface,
        PostMediaInterface $postMediaInterface,
        UserInterface $userInterface,
    ) {
        $this->postInterface = $postInterface;
        $this->postMediaInterface = $postMediaInterface;
        $this->userInterface = $userInterface;
        $this->storageService = app(StorageService::class);
    }

    /**
     * Get the friends Ids.
     *
     * @param int $userId The user's id (posts.user_id)
     *
     * @return mixed
     */
    private function getUserFriendsIds(int $userId)
    {
        // Get the user's friends
        $user = $this->userInterface
            ->find($userId)
            ->load('following');

        // Get the friends Ids
        return $user->following
            ->pluck('followed_id')
            ->toArray();
    }

    /**
     * Get the width and height of an uploaded image.
     *
     * @param \Illuminate\Http\UploadedFile $uploadedFile
     *
     * @return array{width:int, height:int}
     */
    private function getImageSize(UploadedFile $uploadedFile)
    {
        $imageDetails = getImageSize($uploadedFile->getRealPath());

        $width = $imageDetails[0] ?? 0;
        $height = $imageDetails[1] ?? 0;

        return [
            'width' => $width,
            'height' => $height,
        ];
    }

    /**
     * Get the width, height, and duration of an uploaded video.
     *
     * @param \Illuminate\Http\UploadedFile $uploadedFile
     *
     * @return array{width:int, height:int, duration:int}
     */
    private function getVideoSize(UploadedFile $uploadedFile)
    {
        $ffmpeg = FFMpeg::create();

        $video = $ffmpeg->open($uploadedFile->getRealPath());
        $streams = $video
            ->getStreams()
            ->videos()
            ->first();

        return [
            'width' => $streams->get('width') ?? 0,
            'height' => $streams->get('height') ?? 0,
            'duration' => $streams->get('duration') ?? 0,
        ];
    }

    /**
     * Stores the file in storage.
     *
     * @param \Illuminate\Http\UploadedFile $uploadedFile The uplaoded file (image/video)
     * @param int $userId The user's id (posts.user_id)
     * @param string $mediaType (IMAGE/VIDEO)
     *
     * @return array<mixed, string>
     */
    private function processFile(
        UploadedFile $uploadedFile,
        int $userId,
        string $mediaType,
    ): array {
        // Open as read-only stream
        $fileStream = fopen($uploadedFile->getRealPath(), 'r');

        // Generate safe filename using helper
        $safeFilename = generateSafeFilename($uploadedFile);
        $path = "posts/$userId/$safeFilename";

        try {
            $result = $this->storageService->put($path, $fileStream);
        } finally {
            fclose($fileStream);
        }

        $fileSizes = $mediaType === MediaType::IMAGE->value
            ? $this->getImageSize($uploadedFile)
            : $this->getVideoSize($uploadedFile);

        return [
            'is_created' => $result,
            'path' => $path,
            'mime' => $uploadedFile->getClientMimeType(),
            ...$fileSizes,
        ];
    }

    /**
     * Get the posts of the user's friends.
     *
     * @param int $userId The user's id (posts.user_id)
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function handleGetFriendPost(int $userId): Collection
    {
        $userFriendIds = $this->getUserFriendsIds($userId);

        return $this->postInterface->getFriendsPost($userFriendIds);
    }

    /**
     * Get all posts for the home page.
     * Includes authenticated user posts + friends posts.
     *
     * @param int $userId The user's id (posts.user_id)
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function handleGetHomePosts(int $userId): Collection
    {
        $userFriendsIds = $this->getUserFriendsIds($userId);

        return $this->postInterface->getHomePosts($userId, $userFriendsIds);
    }

    /**
     * Handles file uplaod and data insertion in database.
     *
     * @param \Illuminate\Http\Request $requet
     *
     * @return \App\Models\Post|null
     */
    public function handleCreatePost(Request $request)
    {
        $images = Arr::wrap($request->file('images') ?? []);
        // $videos = Arr::wrap($request->file('videos') ?? []);

        $post = $this->postInterface
            ->create($request->only(
                'user_id',
                'content',
                'is_comments_allowed',
                'is_shares_allowed',
            ));

        foreach ($images as $index => $image) {
            if (!$image instanceof UploadedFile) {
                continue;
            }

            $result = $this->processFile(
                $image,
                $post->user_id,
                MediaType::IMAGE->value
            );

            try {
                $this->postMediaInterface->create([
                    'post_id' => $post->id,
                    'type' => MediaType::IMAGE->value,
                    'url' => $result['path'],
                    'mime_type' =>  $result['mime'],
                    'width' => $result['width'],
                    'height' => $result['height'],
                    'duration_seconds' => $result['duration'] ?? null,
                    'sort_order' => $index,
                ]);
            } catch (\Exception $error) {
                $this->storageService->delete($result['path']);

                throw $error;
            }
        }

        return $post->load(['user', 'media']);
    }
}
