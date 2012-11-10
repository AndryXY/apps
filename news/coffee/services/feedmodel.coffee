###
# ownCloud - News app
#
# @author Bernhard Posselt
# Copyright (c) 2012 - Bernhard Posselt <nukeawhale@gmail.com>
#
# This file is licensed under the Affero General Public License version 3 or later.
# See the COPYING-README file
#
###

angular.module('News').factory 'FeedModel', 
['Model', '$rootScope', 
(Model, $rootScope) ->

	class FeedModel extends Model

		constructor: ($rootScope) ->
			super('feeds', $rootScope)

		add: (item) ->
			super(@bindAdditional(item))

		bindAdditional: (item) ->
			if item.icon == "url()"
				item.icon = 'url(' + OC.imagePath('news', 'rss.svg') + ')'
			return item

	return new FeedModel($rootScope)
]