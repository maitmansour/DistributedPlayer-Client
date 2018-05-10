<?php
require 'Ice.php';
require '../app/Player.php';

/**
 * Client Class
 */
class Client
{
    private $ic = null;
    private $base;
    private $player;
    
    function __construct()
    {
        try {
            $this->ic     = Ice\initialize();
            $this->base   = $this->ic->stringToProxy("DistributedPlayer:default -p 10000");
            $this->player = Mp3Player\PlayerPrxHelper::checkedCast($this->base);
            if (!$this->player) {
                throw new RuntimeException("Invalid proxy");
            }
        }
        catch (Exception $ex) {
            echo $ex;
        }
        
    }

    function __destruct()
    {
        if ($this->ic) {
            $this->ic->destroy(); // Clean up
            
        }
    }

    public function getPlayer()
    {
    	return $this->player;
    }
    
}
?>