<?php

namespace App\Entity;

/**
 * Token
 */
class Token
{
	/**
	 * The token to use to connect to the API
	 */
	private $accessToken;

	/**
	 * The date on which the token was generated
	 */
	private $generatedAt;

	/**
	 * The date on which the token expires
	 */
	private $expireAt;

	public function __construct($accessToken, $generatedAt, $expireAt)
	{
		$this->accessToken = $accessToken;
		$this->generatedAt = $generatedAt;
		$this->expireAt = $expireAt;
	}

	public function getAccessToken()
	{
		return $this->accessToken;
	}

	public function getGeneratedAt()
	{
		return $this->generatedAt;
	}

	public function getExpireAt()
	{
		return $this->expireAt;
	}
}