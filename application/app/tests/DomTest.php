<?php

class DomTest extends TestCase {

	public function testHome()
	{
		$crawler = $this->client->request('GET', '/');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testPopular()
	{
		$crawler = $this->client->request('GET', '/popular');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testPopularWeek()
	{
		$crawler = $this->client->request('GET', '/popular/week');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testPopularMonth()
	{
		$crawler = $this->client->request('GET', '/popular/month');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testPopularYear()
	{
		$crawler = $this->client->request('GET', '/popular/year');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testTags()
	{
		$crawler = $this->client->request('GET', '/tags/test');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testCategory()
	{
		$crawler = $this->client->request('GET', '/category/test');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testMedia()
	{
		$crawler = $this->client->request('GET', '/media/highlight-anything-stupid');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testUser()
	{
		$this->setAuthenticatedUser();
		$crawler = $this->client->request('GET', '/user/admin');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testUserLikes()
	{
		$this->setAuthenticatedUser();
		$crawler = $this->client->request('GET', '/user/admin/likes');
		$this->assertTrue($this->client->getResponse()->isOk());
	}

	// User Authenticated functionality

	public function testUpload()
	{
		$this->setAuthenticatedUser();
		$crawler = $this->client->request('GET', '/upload');
		$this->assertTrue($this->client->getResponse()->isOk());
	}


	// Install URL
	public function testInstall()
	{
		$this->client->request('GET', '/install');
		$this->assertRedirectedTo('/');
	}

	// Upgrade URL
	public function testUpgrade()
	{
		$this->client->request('GET', '/upgrade');
		$this->assertRedirectedTo('/');
	}

	// public function testPasswordReset(){
	// 	$crawler = $this->client->request('GET', '/password_reset');
	// 	$this->assertTrue($this->client->getResponse()->isOk());
	// }





	// Helper functions //

	public function setAuthenticatedUser(){
		$user = new User(array('username' => 'johndoe', 'email' => 'johndoe@gmail.com', 'admin' => 0));
		$this->be($user);
	}

	public function setAdminUser(){
		$user = new User(array('username' => 'johndoe', 'email' => 'johndoe@gmail.com', 'admin' => 1));
		$this->be($user);
	}

}