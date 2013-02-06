<?php

class PagesController extends App\Controller
{
  public function index()
  {

  }

  public function show()
  {
    $this->render('index');
  }

  public function test()
  {
    $this->setLayout('test');
    $this->render('index');
  }

  public function whatever()
  {
    $this->view()->title = 'Awesome Title';
    $this->setLayout('test');
    $this->render('index');
  }
}

class ControllerTest extends PHPUnit_Framework_TestCase
{
  protected function setUp()
  {
    $this->controller = new PagesController;
  }

  public function testUnderscore()
  {
    $this->assertEquals( 'hey_whats_up_man', PagesController::underscore('HeyWhatsUpMan') );
  }

  public function testName()
  {
    $this->assertEquals( 'PagesController', $this->controller->name() );
  }

  public function testNameToPath()
  {
    $this->assertEquals( 'pages', $this->controller->nameToPath() );
  }

  public function testViewIsCreatedOnNew()
  {
    $this->assertTrue( $this->controller->view() instanceof App\View );
  }

  public function testSetParams()
  {
    $params = array('key1' => 'value1', 'key2' => 'value2');
    $this->controller->setParams($params);
    $this->assertEquals( $params, $this->controller->params() );
  }

  public function testIndex()
  {
    $this->controller->action('index');
    $view = $this->controller->view();
    $view->setRootPath(ROOT_VIEWS);
    $view->render();
    $this->assertTrue( $view instanceof App\View );
  }

  public function testIndexWithJsFormat()
  {
    $this->controller->action('index');
    $view = $this->controller->view();
    $view->setRootPath(ROOT_VIEWS);
    $view->render('js');
    $this->assertTrue( $view instanceof App\View );
  }

  public function testShow()
  {
    $this->controller->action('show');
    $view = $this->controller->view();
    $view->setRootPath(ROOT_VIEWS);
    $view->render();
    $this->assertTrue( $view instanceof App\View );
  }

  public function testShowWithJsFormat()
  {
    $this->controller->action('show');
    $view = $this->controller->view();
    $view->setRootPath(ROOT_VIEWS);
    $view->render('js');
    $this->assertTrue( $view instanceof App\View );
  }

  public function testTestWithDifferentLayout()
  {
    $this->controller->action('test');
    $view = $this->controller->view();
    $view->setRootPath(ROOT_VIEWS);
    $code = $view->render();
    $this->assertTrue( $view instanceof App\View );
    $this->assertEquals( "<h1>Test!</h1>\n<p>Hello!</p>", trim($code) );
  }

  public function testWhatever()
  {
    $this->controller->action('whatever');
    $view = $this->controller->view();
    $view->setRootPath(ROOT_VIEWS);
    $code = $view->render();
    $this->assertEquals( 'Awesome Title', $view->title );
    $this->assertTrue( $view instanceof App\View );
    $this->assertEquals( "<h1>Test!</h1>\n<p>Hello!</p>", trim($code) );
  }
}
