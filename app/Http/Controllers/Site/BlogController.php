<?php

namespace AgenciaS3\Http\Controllers\Site;

use AgenciaS3\Http\Controllers\Controller;
use AgenciaS3\Repositories\PostImageRepository;
use AgenciaS3\Repositories\PostRepository;
use AgenciaS3\Repositories\PostTagRepository;
use AgenciaS3\Repositories\SeoPageRepository;
use AgenciaS3\Repositories\TagRepository;
use AgenciaS3\Services\UtilObjeto;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class BlogController extends Controller
{
    protected $repository;

    protected $seoPageRepository;

    protected $postTagRepository;

    protected $tagRepository;

    protected $postImageRepository;

    protected $utilObjeto;

    public function __construct(PostRepository $repository,
                                PostImageRepository $postImageRepository,
                                PostTagRepository $postTagRepository,
                                TagRepository $tagRepository,
                                SeoPageRepository $seoPageRepository,
                                UtilObjeto $utilObjeto)
    {
        $this->repository = $repository;
        $this->postImageRepository = $postImageRepository;
        $this->postTagRepository = $postTagRepository;
        $this->tagRepository = $tagRepository;
        $this->seoPageRepository = $seoPageRepository;
        $this->utilObjeto = $utilObjeto;
    }

    public function index(Request $request)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $search = $request->get('search');

        $posts = $this->repository->orderBy('date', 'desc')->getPostsActive(9);
        $tags = $this->tagRepository->orderBy('name', 'asc')->findByField('active', 'y');
        $configSEO = $this->seoPageRepository->find(7);

        $cover = asset('assets/store/images/logo_facebook.jpg');
        SEOMeta::setTitle($configSEO->name);
        SEOMeta::setDescription($configSEO->seo_description);
        SEOMeta::setCanonical(Route::getCurrentRequest()->getUri());
        SEOMeta::addKeyword([$configSEO->seo_keywords]);
        TwitterCard::setTitle($configSEO->name);
        TwitterCard::setDescription($configSEO->seo_description);
        TwitterCard::addImage($cover);

        OpenGraph::setDescription($configSEO->seo_description);
        OpenGraph::setTitle($configSEO->name);
        OpenGraph::setUrl(Route::getCurrentRequest()->getUri());
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'pt-br');
        OpenGraph::addImage($cover, ['height' => 630, 'width' => 1200]);

        return view('site.blog.index', compact('posts', 'tags', 'search'));
    }

    public function tag(Request $request, $seo_link)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $search = $request->get('search');

        $tag = $this->tagRepository->findWhere(['active' => 'y', 'seo_link' => $seo_link])->first();
        if($tag) {
            if (isPost($search)) {
                $this->saveSearch($search, $tag->id);
            }

            $title = $tag->name.' | Blog ';
            $cover = asset('assets/store/images/logo_facebook.jpg');
            SEOMeta::setTitle($title);
            SEOMeta::setDescription($tag->seo_description);
            SEOMeta::setCanonical(Route::getCurrentRequest()->getUri());
            SEOMeta::addKeyword([$tag->seo_keywords]);
            TwitterCard::setTitle($title);
            TwitterCard::setDescription($tag->seo_description);
            TwitterCard::addImage($cover);

            OpenGraph::setDescription($tag->seo_description);
            OpenGraph::setTitle($title);
            OpenGraph::setUrl(Route::getCurrentRequest()->getUri());
            OpenGraph::addProperty('type', 'article');
            OpenGraph::addProperty('locale', 'pt-br');
            OpenGraph::addImage($cover, ['height' => 630, 'width' => 1200]);

            $posts = $this->repository->getPostsTag($tag, 9);
            $tags = $this->tagRepository->orderBy('name', 'asc')->findByField('active', 'y');

            return view('site.blog.index', compact('blog', 'tag', 'tags', 'posts', 'search'));
        }

        return redirect()->route('home');
    }

    public function show(Request $request, $seo_link)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        $post = $this->repository->findWhere(['active' => 'y', 'seo_link' => $seo_link])->first();
        if($post) {
            $images = $this->postImageRepository->orderBy('order', 'asc')->findWhere(['post_id' => $post->id]);
            $postTags = $this->postTagRepository->scopeQuery(function ($query) use ($post) {
                $query = $query->leftjoin('tags as t', 't.id', '=', 'post_tags.tag_id')
                    ->select('post_tags.*')
                    ->where('post_tags.post_id', '=', $post->id)
                    ->where('t.active', '=', 'y');
                return $query;
            })->all();

            $title = $post->name;

            $cover = asset('assets/store/images/logo_facebook.jpg');
            if ($post->images) {
                foreach ($post->images as $image) {
                    if ($image->cover == 'y') {
                        $cover = asset('uploads/blog/' . $image->image);
                    }
                }
            }

            SEOMeta::setTitle($title);
            SEOMeta::setDescription(strip_tags($post->seo_description));
            SEOMeta::setCanonical(Route::getCurrentRequest()->getUri());
            SEOMeta::addKeyword($post->seo_keywords);
            TwitterCard::setTitle($title);
            TwitterCard::setDescription(strip_tags($post->seo_description));
            TwitterCard::addImage($cover);

            OpenGraph::setDescription(strip_tags($post->seo_description));
            OpenGraph::setTitle($title);
            OpenGraph::setUrl(Route::getCurrentRequest()->getUri());
            OpenGraph::addProperty('type', 'article');
            OpenGraph::addProperty('locale', 'pt-br');
            OpenGraph::addProperty('locale:alternate', ['pt-pt', 'en-us', 'es']);
            OpenGraph::addImage($cover, ['height' => 630, 'width' => 1200]);
            OpenGraph::addImage($cover);
            OpenGraph::addImage(['url' => $cover, 'size' => 300]);

            $posts = $this->repository->getPostsRecent($post->id, 4);
            $tags = $this->tagRepository->orderBy('name', 'asc')->findByField('active', 'y');

            return view('site.blog.show', compact('posts','post', 'images', 'postTags', 'tags'));
        }

        return redirect()->route('blog');
    }

    public function getFeatured()
    {
        return $this->repository->getPostsActive(3);
    }

}
