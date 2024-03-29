<?php

namespace SMW;

use Title;
use Job;

/**
 * Dispatcher class to invoke UpdateJob's
 *
 * Can be run either in deferred or immediate mode to restore the data parity
 * between a property and its attached subjects
 *
 * @ingroup SMW
 *
 * @licence GNU GPL v2+
 * @since 1.9
 *
 * @author mwjames
 */
class UpdateDispatcherJob extends JobBase {

	/** @var Job */
	protected $jobs = array();

	/** @var boolean */
	protected $enabled = true;

	/** @var Store */
	protected $store = null;

	/**
	 * @since  1.9
	 *
	 * @param Title $title
	 * @param array $params job parameters
	 * @param integer $id job id
	 */
	public function __construct( Title $title, $params = array(), $id = 0 ) {
		parent::__construct( 'SMW\UpdateDispatcherJob', $title, $params, $id );
		$this->removeDuplicates = true;
	}

	/**
	 * Disables ability to insert jobs into the
	 * JobQueue
	 *
	 * @since 1.9
	 *
	 * @return UpdateDispatcherJob
	 */
	public function disable() {
		$this->enabled = false;
		return $this;
	}

	/**
	 * @see Job::run
	 *
	 * @since  1.9
	 *
	 * @return boolean
	 */
	public function run() {
		Profiler::In( __METHOD__, true );

		/**
		 * @var Store $store
		 */
		$this->store = $this->withContext()->getStore();

		if ( $this->getTitle()->getNamespace() === SMW_NS_PROPERTY ) {
			$this->dispatchUpdateForProperty( DIProperty::newFromUserLabel( $this->getTitle()->getText() ) )->push();
		}

		$this->dispatchUpdateForSubject( DIWikiPage::newFromTitle( $this->getTitle() ) )->push();

		Profiler::Out( __METHOD__, true );
		return true;
	}

	/**
	 * Insert batch jobs
	 *
	 * @note Job::batchInsert was deprecated in MW 1.21
	 * JobQueueGroup::singleton()->push( $job );
	 *
	 * @since 1.9
	 */
	public function push() {
		$this->enabled ? Job::batchInsert( $this->jobs ) : null;
	}

	/**
	 * @see Job::insert
	 *
	 * @since 1.9
	 * @codeCoverageIgnore
	 */
	public function insert() {
		if ( $this->withContext()->getSettings()->get( 'smwgEnableUpdateJobs' ) ) {
			parent::insert();
		}
	}

	/**
	 * @since 1.9.0.1
	 *
	 * @param DIWikiPage $subject
	 */
	protected function dispatchUpdateForSubject( DIWikiPage $subject ) {
		Profiler::In( __METHOD__, true );

		$this->addUpdateJobsForProperties( $this->store->getProperties( $subject ) );
		$this->addUpdateJobsForProperties( $this->store->getInProperties( $subject ) );

		$this->addUpdateJobsFromSerializedData();

		Profiler::Out( __METHOD__, true );
		return $this;
	}

	/**
	 * Generates list of involved subjects
	 *
	 * @since 1.9
	 *
	 * @param DIProperty $property
	 */
	protected function dispatchUpdateForProperty( DIProperty $property ) {
		Profiler::In( __METHOD__, true );

		$this->addUpdateJobsForProperties( array( $property ) );

		// Hook deprecated with SMW 1.9 and will vanish with SMW 1.11
		wfRunHooks( 'smwUpdatePropertySubjects', array( &$this->jobs ) );

		// Hook since 1.9
		wfRunHooks( 'SMW::Dispatcher::updateJobs', array( &$this->jobs, $property ) );

		$this->addUpdateJobsForPropertyWithTypeError();
		$this->addUpdateJobsFromSerializedData();

		Profiler::Out( __METHOD__, true );
		return $this;
	}

	protected function addUpdateJobsForProperties( array $properties ) {
		foreach ( $properties as $property ) {

			if ( $property->isUserDefined() ) {
				$this->addUniqueUpdateJobs( $this->store->getAllPropertySubjects( $property ) );
			}

		}
	}

	protected function addUpdateJobsForPropertyWithTypeError() {
		$subjects = $this->store->getPropertySubjects(
			new DIProperty( DIProperty::TYPE_ERROR ),
			DIWikiPage::newFromTitle( $this->getTitle() )
		);

		$this->addUniqueUpdateJobs( $subjects );
	}

	protected function addUpdateJobsFromSerializedData() {
		if ( $this->hasParameter( 'semanticData' ) ) {
			$this->addUpdateJobsForProperties(
				SerializerFactory::deserialize( $this->getParameter( 'semanticData' ) )->getProperties()
			);
		}
	}

	protected function addUniqueUpdateJobs( array $subjects = array() ) {

		foreach ( $subjects as $subject ) {

			$title = $subject->getTitle();

			if ( $title instanceof Title ) {
				$this->jobs[$title->getPrefixedDBkey()] = new UpdateJob( $title );
			}
		}

	}

}
