const puppeteer = require('puppeteer');
const fs = require('fs');
const penthouse = require('penthouse');
const url = 'https://mestamaster.fi';

(async () => {
    const browser = await puppeteer.launch({
        executablePath: 'google-chrome-stable',
        args: [
            '--disable-dev-shm-usage', // https://github.com/puppeteer/puppeteer/blob/main/docs/troubleshooting.md#tips
        ],
    });

    const page = await browser.newPage();

    page.on('response', async response => {
        if(response.request().resourceType() !== 'stylesheet') return;
        fs.appendFileSync('../customer_data/uncritical.css', await response.text());
    });

    await page.goto(url);
    await browser.close();

    penthouse({
        url,
        css: '../customer_data/uncritical.css',
        // cssString: 'body { color: red }'
    })
        .then(criticalCss => {
            // use the critical css
            fs.writeFileSync('../customer_data/critical.css', criticalCss);
        })
})();

// docker run -it --init --rm --cap-add=SYS_ADMIN -v $(pwd)/criticalcss/src:/home/pptruser/src -v $(pwd)/customer_data:/home/pptruser/customer_data critical_criticalcss node runner.js
