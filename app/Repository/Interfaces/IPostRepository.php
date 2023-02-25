<?php
namespace App\Repositories\Interfaces;

Interface IPostRepository{

    public function allPosts();
    public function storePost($request);
    public function postDetails($id);
    public function updatePost($request, $id);
    public function destroyPost($id);
}
