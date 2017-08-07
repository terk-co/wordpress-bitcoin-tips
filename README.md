# WordPress Bitcoin Tips Plugin

This plugin allows collecting bitcoin tips from WordPress blog readers. Every blog post gets its unique bitcoin address for tips. This allows for detailed stats of tips per post, so you know which texts your readers appreciate the most.

The plugin requires that you use a BIP32/44 deterministic wallet and generates public keys based on xPub provided by you. This allows creating public keys your wallet without knowing your private keys. Only you are in control of all tips you receive.

The plugin uses Blockchain.info API to handle per-post address generation and for notifications on new tips (used for stats displayed on post pages and to send you email notifications). You will need to [apply for an API key at their website](https://api.blockchain.info/customer/signup). It's free to use and they also don't have access to the tips you receive.

After installing the plugin, you need to configure it at in Settings > Bitcoin Tips. You need to provide your xPub key (used to generate public keys for your wallet) and Blockchain.info API key. After you do this, there will be a tipping widget displayed under each post.

Main features as of current version are:

* Automated generation of unique bitcoin address for each post, coming from your private wallet.
* Tipping widget displayed under each post with customised copywriting and bitcoin address QR code.
* Detecting incoming tips and calculating stats per post.
* Publicly displaying post tips stats in the tipping widget (can be turned off).
* Email notifications of received tips (can be turned off).

### Beware of BIP44 gap issue

Please be aware of a BIP44 issue. Most BIP44 wallets scan up to 20 unused keys. If you have more consecutive posts with no tips at all, you might not see tips received for newer posts in your wallet (after the 20 untipped posts gap). The Blockchain.info API (and the plugin) will stop generating new keys after a gap of 20 not-tipped addresses will be detected (and the plugin won't be displayed on these posts). You can increase this gap in the settings if you know how to handle it in your wallet. A simple workaround for this is to generate a new xPub and update it in the plugin settings when you are nearly reaching or have already reached the gap limit.

As new addresses are generated on first pageview of a post which didn't already have an address, you might jump into this issue quickly after installing the plugin if your blog has a long history.

## Installation

Download zipped plugin from [dist/bitcoin-tips-v2.0.0.zip](https://github.com/terk-co/wordpress-bitcoin-tips/raw/master/dist/bitcoin-tips-v2.0.0.zip) or from the [plugin home page](http://terk.co/wordpress-bitcoin-tips-plugin/)

## Tips appreciated

Bitcoin address: 17kMXphVGuXu2qnLJN8RSdo8MvpQH2YjUQ


The plugin is available under the MIT License.