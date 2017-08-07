## WARNING: This plugin is depreciated and doesn't currently work.

This is a plugin from 2013 and it uses Blockchain.info's API which changed since then. Updated version will follow soon.

---

## WordPress Bitcoin Tips Plugin

This plugin allows collecting bitcoin tips from WordPress blog readers. Every blog post gets its unique bitcoin address for tips, which are immediately forwarded to a single address defined in settings. This allows for detailed stats of tips per post, so you know which texts your readers appreciate the most.

The plugin uses Blockchain.info API to collect tips. This makes it compatible with every WordPress environment (i.e. it doesn’t require any bitcoin-specific software like bitcoind). It also adds some level of security, as even if your WordPress is hacked, your received tips are secure as there are no bitcoin private keys stored in your WordPress. Both plugin and Blockchain.info API are free to use.

After installing the plugin, you need to setup your receiving bitcoin address in Settings > Bitcoin Tips and once it’s done, there will be a tipping widget displayed under each post.

Main features as of current version are:

* Automated generation of unique bitcoin address for each post.
* Setting up automatic forwarding of all incoming bitcoins to a single bitcoin address configured in plugin options.
* Tipping widget displayed under each post with customised copywriting and bitcoin address QR code.
* Detecting incoming tips and calculating stats per post.
* Publicly displaying post tips stats in the tipping widget (can be turned off).
* Email notifications of received tips (can be turned off).

The plugin is available under the MIT License.