<?php

/**
 * AllWms presenter.
 */
class AllWmsPresenter extends BasePresenter
{
        /** @var Todo\TaskRepository */
        private $wmsRepository;
        
        protected function startup()
        {
            parent::startup();
            $this->wmsRepository = $this->context->wmsRepository;
        }
	
        public function renderDefault()
	{
            $this->template->wmss = $this->wmsRepository->findAll();
	}

}


