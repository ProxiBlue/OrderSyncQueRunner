OrderSyncQueRunner
==================

Sync magento orders to external system via que

The standard magento way to sync orders placed, to external systems, is to use the 'sales_order_place_after' event.
(This is even a question in the magento certification exam)

I have a problem with this: latency at checkout!

Using this (prescribed) method to sync your orders, you can add at least 3+ seconds (and as long as xx seconds) to the checkout process.
That is unwanted lag, and delay for your customers, just to se their success page display.

It can even cause the order to fail! (but payment was taken, which cause some really embarrassing problems for any retailer)

So what is the solution?

Simple - do the sync process outside the order process, via a cron.

I already had a couple of clients that used the 'sales_order_place_after' event to effect sync to their 3rd party systems, each using a custom built magento module to do the sync.
The goal of this module was not to replace those modules, but to make them sync outside the standard magento order process.

The answer is really simple:

1. This module listens to the 'sales_order_place_after' event, and grabs the order id (and some other data), and places it in a database table.
2. It then fires a cron job every 5 minutes which gets the data from the table (for those orders not yet marked as synced), and the fires a new event called 'sales_order_place_after_que'
3. The sync module were changes to listen to the 'sales_order_place_after_que event'

The end result:

A order sync que system, which successfully syncs orders to external systems.
Any module (or observer) that used to listen to sales_order_place_after can be adjusted to listen to 'sales_order_place_after_que' instead, with no further code changes.
The que event is identical to the original sales_order_place_after event.

Nothing fancy, and no manual sync buttons (yet)
It will retry any orders that are not marked as synced, or until they are marked as synced.
There is a new menu option under 'Orders' which allows you to view the sync status.
There is a weekly cron that cleans the table of all synced orders, thus preventing it from getting to large.


Our Premium extensions:
----------------------
[Magento Free Gift Promotions](http://www.proxiblue.com.au/magento-gift-promotions.html "Magento Free Gift Promotions")
The ultimate magento gift promotions module - clean code, and it just works!

[Magento Dynamic Category Products](http://www.proxiblue.com.au/magento-dynamic-category-products.html "Magento Dynamic Category Products")
Automate Category Product associations - assign any product to a category, using various rules.
