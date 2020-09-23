# Hubspot info for our form pages

API to improve our forms and Wordpress pages.

**This API allows you to check:**

- If an email is in Hubspot
- The lifecycle, to confirm that's an active donor
- If the user has the phone number in Hubspot / Salesforce
- If the user has opted out
- The Hubspot lists the user is in
- The Salesforce campaigns the user is in

**It can be used to:**

- Improve web analytics, including Google Analytics, Google Adwords Facebook Ads and others
- Create content in the thank you page that depends on the user
- Have better privacy management
- Progressive forms
- Click-to-go petitions

## Install the script

1. **Create a subdomain on your server** for the script. If you use php-fpm with Nginx you should also create and a Linux user for your script and make php-fpm run on that user. Don't forget to enable https in your subdomain.
2. Rename `includes/config.php.dist` to `includes/config.php`. and protect it from being read by other system users `chmod 700 includes/config.php`.
3. Edit this file add **access to Hubspot** with your [your Hubspot API Key](https://knowledge.hubspot.com/integrations/how-do-i-get-my-hubspot-api-key). Finally update the list of **domains that will use this script**.
4. If you are using Nginx, protect the config folder inside your path by adding this code to your subdomain conf file:

```
location ^~ /path-to-your-api/includes/ {
    deny all;
}
````

## Use

To get the data from a user visit the url:

`https://your-sub.domain.org/route/?email=example@test.com`
