<?php

class ViewTest extends PHPUnit_Framework_TestCase
{
  public function testSetRootPath()
  {
    $view = new App\View('pages/index');
    $view->setRootPath(ROOT_VIEWS);
    $this->assertEquals( ROOT_VIEWS, $view->rootPath() );
    $view->render();
  }

  /**
   * @expectedException InvalidArgumentException
   */
  public function testInvalidSetRootPath()
  {
    $view = new App\View('pages/index');
    $view->setRootPath('nonexistent/path');
  }

  /**
   * @expectedException InvalidArgumentException
   */
  public function testViewWithWrongFormat()
  {
    $view = new App\View('pages/index');
    $view->setRootPath(ROOT_VIEWS);
    $view->render('brekeke');
  }

  public function testViewPathWithDefaultFormat()
  {
    $view = new App\View('pages/index');
    $view->setRootPath(ROOT_VIEWS);
    $code = $view->render();
    $this->assertEquals( ROOT_VIEWS . '/pages/index.html.php', $view->path() );
  }

  public function testViewContentsWithDefaultFormat()
  {
    $view = new App\View('pages/index');
    $view->setRootPath(ROOT_VIEWS);
    $code = $view->render();
    $this->assertEquals( "<html>\n<p>Hello!</p>\n</html>", trim($code) );
  }

  /**
   * @expectedException App\ViewNotFoundException
   */
  public function testViewWithInvalidPath()
  {
    $view = new App\View('pages/nonexistent');
    $view->setRootPath(ROOT_VIEWS);
    $view->render();
  }

  public function testViewPathWithHtmlFormat()
  {
    $view = new App\View('pages/index');
    $view->setRootPath(ROOT_VIEWS);
    $code = $view->render('html');
    $this->assertEquals( ROOT_VIEWS . '/pages/index.html.php', $view->path() );
  }

  public function testViewContentsWithHtmlFormat()
  {
    $view = new App\View('pages/index');
    $view->setRootPath(ROOT_VIEWS);
    $code = $view->render('html');
    $this->assertEquals( "<html>\n<p>Hello!</p>\n</html>", trim($code) );
  }

  public function testViewPathWithJsFormat()
  {
    $view = new App\View('pages/index');
    $view->setRootPath(ROOT_VIEWS);
    $code = $view->render('js');
    $this->assertEquals( ROOT_VIEWS . '/pages/index.js.php', $view->path() );
  }

  public function testViewContentsWithJsFormat()
  {
    $view = new App\View('pages/index');
    $view->setRootPath(ROOT_VIEWS);
    $code = $view->render('js');
    $this->assertEquals( "$('a.link');", trim($code) );
  }

  public function testViewWithNoLayout()
  {
    $view = new App\View('pages/index');
    $view->setRootPath(ROOT_VIEWS);
    $view->setLayout(null);
    $code = $view->render();
    $this->assertEquals( '<p>Hello!</p>', trim($code) );
  }

  public function testUnderscoreLastItem1()
  {
    $this->assertEquals( 'pages/_partial', App\View::underscoreLastItem('pages/partial') );
  }

  public function testUnderscoreLastItem2()
  {
    $this->assertEquals( '/pages/_partial', App\View::underscoreLastItem('/pages/partial') );
  }

  public function testUnderscoreLastItem3()
  {
    $this->assertEquals( 'pages/folder/_partial', App\View::underscoreLastItem('pages/folder/partial') );
  }

  public function testUnderscoreLastItem4()
  {
    $this->assertEquals( '/pages/folder/_partial', App\View::underscoreLastItem('/pages/folder/partial') );
  }

  public function testViewWithRelativePartial()
  {
    $view = new App\View('pages/partials_with_relative');
    $view->setRootPath(ROOT_VIEWS);
    $code = $view->render();
    $this->assertEquals( "<html>\n<p>Start of view.</p>\n<p>Relative partial.</p>\n<p>End of view.</p>\n</html>", trim($code) );
  }

  public function testViewWithAbsolutePartial()
  {
    $view = new App\View('pages/partials_with_absolute');
    $view->setRootPath(ROOT_VIEWS);
    $code = $view->render();
    $this->assertEquals( "<html>\n<p>Start of view.</p>\n<p>Absolute partial.</p>\n<p>End of view.</p>\n</html>", trim($code) );
  }

  /**
   * @expectedException App\ViewNotFoundException
   */
  public function testViewWithNonexistentPartial()
  {
    $view = new App\View('pages/partials_with_error');
    $view->setRootPath(ROOT_VIEWS);
    $view->render();
  }
}
