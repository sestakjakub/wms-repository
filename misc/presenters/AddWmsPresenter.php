<?php

/**
 * AddWms presenter.
 */
class AddWmsPresenter extends BasePresenter
{

        
        public function renderAdd($address)
	{
            $this->context->parser->ParseAndAddToDB($address);
	}
        
        public function renderDefault()
	{
            $data = array(
                "http://mapserver-slp.mendelu.cz/cgi-bin/mapserv?map=%2Fvar%2Flocal%2Fslp%2FkrtinyWMS.map&SERVICE=WMS&REQUEST=GetCapabilities",
                "http://geoportal.gov.cz/ArcGIS/services/CENIA/cenia_hluk/MapServer/WMSServer?SERVICE=WMS&REQUEST=GetCapabilities",
                "http://wms.cuzk.cz/wms.asp?SERVICE=WMS&REQUEST=GetCapabilities",
                "http://geoportal.gov.cz/ArcGIS/services/CENIA/cenia_hluk/MapServer/WMSServer?SERVICE=WMS&REQUEST=GetCapabilities",
            );
            
            $this->template->wmss= $data;
	}

}


