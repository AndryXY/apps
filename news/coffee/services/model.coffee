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

angular.module('News').factory 'Model', ->

	class Model

		constructor: () ->
			@items = []
			@itemIds = {}


		add: (item) ->
			# check if we need to update or create the item
			if @itemIds[item.id] != undefined
				@update(item)
			else
				@items.push(item)
				@itemIds[item.id] = item


		update: (item) ->
			updatedItem = @itemIds[item.id]
			for key, value of item
				if key != 'id'
					updatedItem[key] = value


		removeById: (id) ->
			removeItemIndex = null
			counter = 0
			for item in @items
				if item.id == id
					removeItemIndex = counter
					break
				counter += 1

			if removeItemIndex != null
				@items.splice(removeItemIndex, 1)
				delete @itemIds[id]



		removeByIds: (ids) ->
			newItems = []
			newItemIds = {}
			for item in @items
				if not ids[item.id]
					newItems.push(item)
					newItemIds[item.id] = item
			@items = newItems
			@itemIds = newItemIds

		getItemById: (id) ->
			return @itemIds[id]


		getItems: () ->
			return @items