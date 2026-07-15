<?php

namespace App\Controllers;

use App\Entities\DecretoEntity;
use App\Models\DecretoModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourcePresenter;

/**
 * @property DecretoModel $model
 */
class DecretoController extends ResourcePresenter
{
    protected $modelName = DecretoModel::class;

    /**
     * Present a view of resource objects.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        if ($this->request->isAJAX()) {
            return $this->response->setJSON($this->model->findAll());
        }

        return view('decreto/index', [
            'title' => 'Lista de decretos',
        ]);
    }

    /**
     * Present a view to present a specific resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null) {}

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
    public function create()
    {
        $decreto = new DecretoEntity($this->request->getPost());

        if (! $this->model->save($decreto)) {
            return redirect()->back()->withInput()
                ->with('message', $this->model->errors())
                ->with('color', 'danger');
        }

        return redirect(self::class)
            ->with('message', 'Decreto cadastrado!')
            ->with('color', 'success');
    }

    /**
     * Present a view to edit the properties of a specific resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        $decreto = $this->model->findOrNotFound($id);

        return view('decreto/edit', [
            'title'   => 'Edição de decreto',
            'decreto' => $decreto,
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
    public function update($id = null)
    {
        $decreto = $this->model->findOrNotFound($id);
        $decreto->fill($this->request->getPost());

        if ($decreto->hasChanged()) {
            if (! $this->model->save($decreto)) {
                return redirect()
                    ->with('message', $this->model->errors())
                    ->with('color', 'danger');
            }
        }

        return redirect(self::class)
            ->with('message', 'Decreto atualizado!')
            ->with('color', 'success');
    }

    /**
     * Present a view to confirm the deletion of a specific resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function remove($id = null)
    {
        $decreto = $this->model->findOrNotFound($id);

        return view('decreto/remove', [
            'title'   => 'Exclusão de decreto',
            'decreto' => $decreto,
        ]);
    }

    /**
     * Process the deletion of a specific resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        if (! $this->model->delete($id)) {
            return redirect()
                ->with('message', $this->model->errors())
                ->with('color', 'danger');
        }

        return redirect(self::class)
            ->with('message', 'Decreto excluído!')
            ->with('color', 'success');
    }
}
