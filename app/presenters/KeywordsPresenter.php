<?php

/**
 * Keywords presenter.
 */
class KeywordsPresenter extends BasePresenter
{

	/** @var Wms\KeywordRepository */
        private $keywordRepository;
        
        protected function startup()
        {
            parent::startup();
            $this->keywordRepository = $this->context->keywordRepository;
        }
	
        public function renderDefault()
	{
            $this->template->keywords = $this->keywordRepository->findAll();
	}

}
