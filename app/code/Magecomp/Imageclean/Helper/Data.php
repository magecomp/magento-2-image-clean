<?php
namespace Magecomp\Imageclean\Helper;

use Magecomp\Imageclean\Model\ImagecleanFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\DB\Exception;

class Data extends AbstractHelper {
    /**
     * @var ImagecleanFactory
     */
    protected $_modelImagecleanFactory;


    public function __construct(Context $context, 
        ImagecleanFactory $modelImagecleanFactory)
    {
        $this->_modelImagecleanFactory = $modelImagecleanFactory;
        parent::__construct($context);
    }


    protected $result = [];
    protected $_mainTable;
    public $valdir = [];

    public function listDirectories($path) 
	{
        if (is_dir($path)) 
		{
            if ($dir = opendir($path)) 
			{
                while (($entry = readdir($dir)) !== false) 
				{
                    if (preg_match('/^\./', $entry) != 1) 
					{
                        if (is_dir($path . DIRECTORY_SEPARATOR . $entry) && !in_array($entry, ['cache', 'watermark', 'placeholder'])) 
						{
                            $this->listDirectories($path.DIRECTORY_SEPARATOR.$entry);
                        } 
						elseif (!in_array($entry, ['cache', 'watermark']) && (strpos($entry, '.') != 0)) 
						{
                            $this->result[] = substr($path.DIRECTORY_SEPARATOR.$entry,25);
                        }
                    }
                }
                closedir($dir);
            }
        }
        return $this->result;
    }

    public function compareList() 
	{
        $valores = $this->_modelImagecleanFactory->create()->getCollection()->getImages();
        $pepe = 'pub'.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'catalog'.DIRECTORY_SEPARATOR.'product';
        $leer = $this->listDirectories($pepe);
        $model = $this->_modelImagecleanFactory->create();
        foreach ($leer as $item) 
		{
            try 
			{
                $item = strtr($item, '\\', '/');
				
                if (!in_array($item, $valores)) 
				{
                    $valdir[]['filename'] = $item;
                    $model->setData(['filename' => $item])->setId(null);
                    $model->save();
                }
            } 
			catch (\Exception $e) 
			{
				$om = \Magento\Framework\App\ObjectManager::getInstance();
				$storeManager = $om->get('Psr\Log\LoggerInterface');
				$storeManager->info($e->getMessage());
			} 
        }
    }

}
