<?php

namespace AgenciaS3\Http\Controllers\Admin;

use AgenciaS3\Entities\Notification;
use AgenciaS3\Entities\User;
use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Mail\Notification\NewPostMail;
use AgenciaS3\Repositories\NotificationRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{

    protected $repository;

    public function __construct(NotificationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $config = $this->header();
        $dados = $this->repository->orderBy('created_at', 'desc')->findByField('user_id', Auth::user()->id);

        return view('admin.notification.index', compact('dados', 'config'));
    }

    public function header()
    {
        $config['title'] = "Post";
        $config['activeMenu'] = "post";
        $config['activeMenuN2'] = "post";

        return $config;
    }

    public function createAdmin($name, $link_url = '')
    {
        //lista usuarios admin
        $users = User::where('role', 'admin')->get();
        if ($users) {
            foreach ($users as $user) {
                $data['user_id'] = $user->id;
                $data['name'] = $name;
                $data['link_url'] = $link_url;
                $data['view'] = 'n';
                $dados = $this->save($data);

                //notification por e-mail
                Mail::to($user->email)->send(new NewPostMail($dados));
            }

            return true;
        }

        return false;
    }

    public function save($data)
    {
        return $this->repository->create($data);
    }

    public function listHeader()
    {
        return $this->repository->orderBy('created_at', 'desc')->findWhere(['user_id' => Auth::user()->id, 'view' => 'n']);
    }

    public function view($id)
    {
        $dados = $this->repository->find($id);

        if($dados) {
            $data = $dados->toArray();
            $data['view'] = 'y';
            $this->repository->update($data, $id);

            if($data['link_url']){
                return redirect($data['link_url']);
            }

            return redirect()->route('admin.notification.index');
        }

        return false;
    }

    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);
        return redirect()->back()->with('success', 'Registro removido com sucesso!');
    }

}