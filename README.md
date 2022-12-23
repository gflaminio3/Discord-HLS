
#  📺 Discord-HLS
> Note: This is for educational purposes. It's just an idea that came on my mind while I was heading back home :)

## Discord-HLS, a project involving PHP and the HTTP Live Streaming protocol.

Before starting, please make sure you have:
- Basic knowledge about the HLS protocol
- A Discord text channel [webhook](https://support.discord.com/hc/en-us/articles/228383668-Intro-to-Webhooks) 
- PHP 7.2+ with PHP cURL extension

# Preamble
As a free time gamer, I use Discord to communicate and play with my friends, that's an awesome service, because I can voice call, text and send files. As I like to do, I always try to think out-of-the-box when I need to solve some issues.
In my case, I had to share an uncompressed 4K video to a friend of mine, but every free video sharing website couldn't allow me to do it, so I've decided to have fun with WebHooks and Discord.

# Why HLS?
Big companies such as Netflix, Amazon, YouTube, split their content into smaller pieces in order to give the end-user a faster video loading, and sometimes, the possibility to choose between certain video qualities. <br>
## Example of a fragmented video file:
![immagine](https://user-images.githubusercontent.com/114490362/206589370-2ce25dd0-6f36-40fc-bf8e-c9a2bc574188.png)

# Applying the concept in our project
Like the big ones, our goal is to break a file into small pieces in order to upload them into the Discord CDN using a Webhook. <br> 
But, Discord has got some limitations to It's Webhook API.

# Discord Limitations
We have to consider some limitations:
- default max file size accepted is 8MB
- 30 requests per minute per Webhook

# Creating a playlist
You can generate a playlist by running the proof.php file. Either way, you can implement the uploadFile() function into your code, this will return the Discord CDN media URL. 

# Playlist Example
![immagine](https://user-images.githubusercontent.com/114490362/206722820-1e1b5a5a-ac14-4e22-945d-b6fab4a83318.png)
