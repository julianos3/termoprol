<?php

namespace AgenciaS3\Http\Controllers\Site;

use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Repositories\ModalityRepository;
use AgenciaS3\Repositories\PostRepository;
use AgenciaS3\Repositories\ServiceRepository;
use AgenciaS3\Repositories\TagRepository;

class SiteMapController extends Controller
{

    protected $serviceRepository;

    protected $modalityRepository;

    protected $tagRepository;

    protected $postRepository;

    public function __construct(ServiceRepository $serviceRepository,
                                ModalityRepository $modalityRepository,
                                TagRepository $tagRepository, PostRepository $postRepository)
    {
        $this->serviceRepository = $serviceRepository;
        $this->modalityRepository = $modalityRepository;
        $this->tagRepository = $tagRepository;
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $services = $this->serviceRepository->findByField('active', 'y');
        $modalities = $this->modalityRepository->findByField('active', 'y');
        $tags = $this->tagRepository->findByField('active', 'y');
        $posts = $this->postRepository->findByField('active', 'y');

        return response()->view('sitemap.index', compact('services', 'modalities', 'tags', 'posts'))->header('Content-Type', 'text/xml');
    }
}
