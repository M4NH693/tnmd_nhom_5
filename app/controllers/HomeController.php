<?php
class HomeController extends Controller {
    public function index() {
        $bookModel = $this->model('Book');
        $categoryModel = $this->model('Category');

        $data = [
            'pageTitle'    => 'BookStore - Hiệu sách trực tuyến',
            'featured'     => $bookModel->getFeatured(8),
            'newArrivals'  => $bookModel->getNewArrivals(8),
            'categories'   => $categoryModel->getWithBookCount(),
        ];

        $this->view('home/index', $data);
    }
}
