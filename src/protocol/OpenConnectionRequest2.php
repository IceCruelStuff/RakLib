<?php

/*
 * RakLib network library
 *
 *
 * This project is not affiliated with Jenkins Software LLC nor RakNet.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 */

declare(strict_types=1);

namespace raklib\protocol;

#include <rules/RakLibPacket.h>

use pocketmine\utils\BinaryStream;
use raklib\utils\InternetAddress;

class OpenConnectionRequest2 extends OfflineMessage{
	public static $ID = MessageIdentifiers::ID_OPEN_CONNECTION_REQUEST_2;

	/** @var int */
	public $clientID;
	/** @var InternetAddress */
	public $serverAddress;
	/** @var int */
	public $mtuSize;

	protected function encodePayload(BinaryStream $out) : void{
		$this->writeMagic($out);
		$this->putAddress($this->serverAddress, $out);
		$out->putShort($this->mtuSize);
		$out->putLong($this->clientID);
	}

	protected function decodePayload(BinaryStream $in) : void{
		$this->readMagic($in);
		$this->serverAddress = $this->getAddress($in);
		$this->mtuSize = $in->getShort();
		$this->clientID = $in->getLong();
	}
}
