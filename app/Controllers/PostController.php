<?php

namespace App\Controllers;

use App\Models\PostModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourcePresenter;

/**
 * @property PostModel $model
 */
class PostController extends ResourcePresenter
{
    protected $helpers   = ['form'];
    protected $modelName = PostModel::class;

    /**
     * Present a view of resource objects.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        if ($this->request->isAJAX()) {
            $posts = $this->model->findAll();

            return $this->response->setJSON($posts);
        }

        return view('post/index', [
            'Lista de postagens',
        ]);
    }

    /**
     * Present a view to present a specific resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $post = $this->model->findOrNotFound($id);

        return view('post/show', [
            'post' => $post,
        ]);
    }

    /**
     * Present a view to present a new single resource object.
     *
     * @return ResponseInterface
     */
    public function new() {}

    /**
     * Process the creation/insertion of a new resource object.
     * This should be a POST.
     *
     * @return ResponseInterface
     */
    public function create() {}

    /**
     * Present a view to edit the properties of a specific resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        return view('post/edit', [
            'post' => $this->model->findOrNotFound($id),
        ]);
    }

    /**
     * Process the updating, full or partial, of a specific resource object.
     * This should be a POST.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null) {}

    /**
     * Present a view to confirm the deletion of a specific resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function remove($id = null) {}

    /**
     * Process the deletion of a specific resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null) {}

    public function truncate()
    {
        $this->model->builder()->truncate();

        return redirect('posts');
    }
}
