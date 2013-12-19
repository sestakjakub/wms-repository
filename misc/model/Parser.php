<?php
namespace Wms;
use Nette;

class Parser extends Nette\Object
{
    /** @var Nette\Database\Connection */
    protected $connection;
    private $wms;
    private $keywordRepository;

    public function __construct(Nette\Database\Connection $db, KeywordRepository $keywordRepository)
    {
        $this->connection = $db;
        $this->keywordRepository = $keywordRepository;
    }
    
    public function ParseAnsAddLayerToDB($layersXML, $upperLayer)
    {
        foreach ($layersXML->Layer as $layerXML)
        {
            $name = (string) $layerXML->Name;
            $title = (string)  $layerXML->Title;
            $abstract = (string)  $layerXML->Abstract;
            $minScale = (double) $layerXML->minScale;
            $maxScale = (double) $layerXML->maxScale;
            
            $west = "";
            if($layerXML->EX_GeographicBoundingBox->westBoundLongitude != "")
            {
                $west = $layerXML->EX_GeographicBoundingBox->westBoundLongitude;
            }
            if($layerXML->LatLonBoundingBox['minx'] != "")
            {
                $west = $layerXML->LatLonBoundingBox['minx'];
            }


            $east = "";
            if($layerXML->EX_GeographicBoundingBox->eastBoundLongitude != "")
            {
                $east = $layerXML->EX_GeographicBoundingBox->eastBoundLongitude;
            }
            if($layerXML->LatLonBoundingBox['maxx'] != "")
            {
                $east = $layerXML->LatLonBoundingBox['maxx'];
            }

            $north = "";
            if($layerXML->EX_GeographicBoundingBox->northBoundLatitude != "")
            {
                $north = $layerXML->EX_GeographicBoundingBox->northBoundLatitude;
            }
            if($layerXML->LatLonBoundingBox['miny'] != "")
            {
                $north = $layerXML->LatLonBoundingBox['miny'];
            }

            $south = "";
            if($layerXML->EX_GeographicBoundingBox->southBoundLatitude != "")
            {
                $south = $layerXML->EX_GeographicBoundingBox->southBoundLatitude;
            }
            if($layerXML->LatLonBoundingBox['maxy'] != "")
            {
                $south = $layerXML->LatLonBoundingBox['maxy'];
            }
            
            if ($upperLayer==null)
            {
            $layer = $this->wms->related("layer")->insert(array("name"=>$name,
            "title"=>$title,
            "layer_id"=>null,
            "abstract"=>$abstract,
            "minScale"=>$minScale,
            "maxScale"=>$maxScale,
            "bBoxWest"=> (double) $west,
            "bBoxEast"=> (double) $east,
            "bBoxNorth"=> (double) $north,
            "bBoxSouth"=> (double) $south,
            ));
            }
            else
            {
            $layer = $upperLayer->related("layer")->insert(array("name"=>$name,
            "title"=>$title,
            "wms_id"=>$this->wms->id,
            "layer_id"=>$upperLayer->id,
            "abstract"=>$abstract,
            "minScale"=>$minScale,
            "maxScale"=>$maxScale,
            "bBoxWest"=> (double) $west,
            "bBoxEast"=> (double) $east,
            "bBoxNorth"=> (double) $north,
            "bBoxSouth"=> (double) $south,
            ));
            }
            
            if($layerXML->KeywordList->Keyword)
            {
                foreach ($layerXML->KeywordList->Keyword as $keyword)
                {
                    $stringKeyword = (string) $keyword;
                    $key = $this->keywordRepository->GetKeywordFromName($stringKeyword);
                    $this->connection->table("layer_has_keyword")->insert(array("layer_id"=>$layer->id, "keyword_id"=>$key->id));
                }
            }
            
            $this->ParseAnsAddLayerToDB($layerXML, $layer);
            
            
        }
    }
    
    
    public function ParseAndAddToDB($address)
    {
        $xml = simplexml_load_file($address);
        $name = (string) $xml->Service->Name;
        $title = (string) $xml->Service->Title;
        $abstract = (string) $xml->Service->Abstract;
        $wmsUrl = $address;
        $version = (string) $xml['version'];
        $fees = (string) $xml->Service->fees;
        $accessConstraints = (string) $xml->Service->accessConstraints;
        $layerLimit = (int) $xml->Service->LayerLimit;
            
        
        if (($name)=="" && ($title)=="")
        {
            return 0;
        }
        
        $this->wms = $this->connection->table("Wms")->insert(array("name"=>$name,
            "title"=>$title,
            "abstract"=>$abstract,
            "wmsUrl"=>$wmsUrl,
            "fees"=>$fees,
            "accessConstraints"=>$accessConstraints,
            "version"=>$version,
            "layerLimit"=>$layerLimit
            ));
        if($xml->Service->KeywordList->Keyword)
        {
            foreach ($xml->Service->KeywordList->Keyword as $keyword)
            {
                $stringKeyword = (string) $keyword;
                $key = $this->keywordRepository->GetKeywordFromName($stringKeyword);
                $this->connection->table("wms_has_keyword")->insert(array("wms_id"=>$this->wms->id, "keyword_id"=>$key->id));
            }
        }
        $this->ParseAnsAddLayerToDB($xml->Capability, null);
    }
}