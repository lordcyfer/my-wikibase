( function( wb, util ) {
	'use strict';

var MODULE = wb.serialization,
	PARENT = MODULE.Deserializer,
	SiteLinkDeserializer = require( './SiteLinkDeserializer.js' );

/**
 * @class wikibase.serialization.SiteLinkSetDeserializer
 * @extends wikibase.serialization.Deserializer
 * @since 2.0
 * @license GPL-2.0+
 * @author H. Snater < mediawiki@snater.com >
 *
 * @constructor
 */
module.exports = util.inherit( 'WbSiteLinkSetDeserializer', PARENT, {
	/**
	 * @inheritdoc
	 *
	 * @return {wikibase.datamodel.SiteLinkSet}
	 */
	deserialize: function( serialization ) {
		var siteLinks = [],
			siteLinkDeserializer = new SiteLinkDeserializer();

		for( var siteId in serialization ) {
			siteLinks.push( siteLinkDeserializer.deserialize( serialization[siteId] ) );
		}

		return new wikibase.datamodel.SiteLinkSet( siteLinks );
	}
} );

}( wikibase, util ) );
