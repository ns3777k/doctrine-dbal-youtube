<?php

namespace Ns3777k\DoctrineDbalYoutube\VO;

class IpBlock
{
    public function __construct(private string $ipBlock)
    {
    }

    public function toHumanReadable(): string
    {
        return $this->ipBlock;
    }
}
