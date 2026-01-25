<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Community;
use App\Models\User;

class CommunityController extends Controller
{
    private Community $community;

    public function __construct()
    {
        $this->community = new Community();
    }

    private function checkAuth()
    {
        if (!User::isAuthenticaded()) {
            header('Location: ' . APP_ROOT . '/login');
            exit;
        }
    }

    public function index()
    {
        $this->checkAuth();
        $posts = $this->community->getFeed();

        // Prepare data for the view
        foreach ($posts as &$post) {
            $post['likes_count'] = $this->community->getLikesCount($post['id']);
            $post['comments'] = $this->community->getComments($post['id']);
            $post['is_liked'] = $this->community->isLiked($post['id'], $_SESSION['user']['id']);
        }

        $this->view('home/community', ['posts' => $posts]);
    }

    public function createPost()
    {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = $_POST['content'] ?? '';
            $title = substr($content, 0, 50) . (strlen($content) > 50 ? '...' : '');

            if (!empty($content)) {
                $this->community->createPost($_SESSION['user']['id'], $title, $content);
            }
        }
        header('Location: ' . APP_ROOT . '/community');
    }

    public function addComment()
    {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postId = (int) ($_POST['post_id'] ?? 0);
            $content = $_POST['content'] ?? '';

            if ($postId > 0 && !empty($content)) {
                $this->community->addComment($postId, $_SESSION['user']['id'], $content);
            }
        }
        header('Location: ' . APP_ROOT . '/community');
    }

    public function toggleLike()
    {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postId = (int) ($_POST['post_id'] ?? 0);
            if ($postId > 0) {
                $this->community->toggleLike($postId, $_SESSION['user']['id']);
            }
        }
        header('Location: ' . APP_ROOT . '/community');
    }
}
