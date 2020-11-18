<?php

namespace Wikibase\Repo\Tests\Rdf\Values;

use DataValues\StringValue;
use Wikibase\DataAccess\EntitySourceDefinitions;
use Wikibase\DataAccess\Tests\DataAccessSettingsFactory;
use Wikibase\DataModel\Entity\PropertyId;
use Wikibase\Rdf\RdfVocabulary;
use Wikibase\Rdf\Values\CommonsMediaRdfBuilder;
use Wikibase\Repo\Tests\Rdf\NTriplesRdfTestHelper;
use Wikimedia\Purtle\NTriplesRdfWriter;
use Wikibase\DataModel\Snak\PropertyValueSnak;

/**
 * @covers \Wikibase\Rdf\Values\CommonsMediaRdfBuilder
 *
 * @group Wikibase
 * @group WikibaseRdf
 *
 * @license GPL-2.0-or-later
 * @author Daniel Kinzler
 */
class CommonsMediaRdfBuilderTest extends \PHPUnit\Framework\TestCase {

	/**
	 * @var NTriplesRdfTestHelper
	 */
	private $helper;

	protected function setUp() {
		parent::setUp();

		$this->helper = new NTriplesRdfTestHelper();
	}

	public function testAddValue() {
		$vocab = new RdfVocabulary(
			[ '' => 'http://test/item/' ],
			[ '' => 'http://test/data/' ],
			DataAccessSettingsFactory::repositoryPrefixBasedFederation(),
			new EntitySourceDefinitions( [] ),
			'',
			[ '' => '' ],
			[ '' => '' ]
		);
		$builder = new CommonsMediaRdfBuilder( $vocab );

		$writer = new NTriplesRdfWriter();
		$writer->prefix( 'www', "http://www/" );
		$writer->prefix( 'acme', "http://acme/" );

		$writer->start();
		$writer->about( 'www', 'Q1' );

		$snak = new PropertyValueSnak(
			new PropertyId( 'P1' ),
			new StringValue( 'Bunny.jpg' )
		);

		$builder->addValue( $writer, 'acme', 'testing', 'DUMMY', $snak );

		$expected = '<http://www/Q1> <http://acme/testing> <http://commons.wikimedia.org/wiki/Special:FilePath/Bunny.jpg> .';
		$this->helper->assertNTriplesEquals( $expected, $writer->drain() );
	}

	public function testAddValue_entitySourceBasedFederation() {
		$vocab = new RdfVocabulary(
			[ '' => 'http://test/item/' ],
			[ '' => 'http://test/data/' ],
			DataAccessSettingsFactory::entitySourceBasedFederation(),
			new EntitySourceDefinitions( [] ),
			'',
			[ '' => '' ],
			[ '' => '' ]
		);
		$builder = new CommonsMediaRdfBuilder( $vocab );

		$writer = new NTriplesRdfWriter();
		$writer->prefix( 'www', "http://www/" );
		$writer->prefix( 'acme', "http://acme/" );

		$writer->start();
		$writer->about( 'www', 'Q1' );

		$snak = new PropertyValueSnak(
			new PropertyId( 'P1' ),
			new StringValue( 'Bunny.jpg' )
		);

		$builder->addValue( $writer, 'acme', 'testing', 'DUMMY', $snak );

		$expected = '<http://www/Q1> <http://acme/testing> <http://commons.wikimedia.org/wiki/Special:FilePath/Bunny.jpg> .';
		$this->helper->assertNTriplesEquals( $expected, $writer->drain() );
	}

}