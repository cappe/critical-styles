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
        fs.appendFileSync('uncritical.css', await response.text());
    });

    await page.goto(url);
    await browser.close();

    penthouse({
        url,
        css: 'uncritical.css',
        // cssString: 'body { color: red }'
    })
        .then(criticalCss => {
            // use the critical css
            fs.writeFileSync('critical.css', criticalCss);
        })
})();

// docker run -it --init --rm --cap-add=SYS_ADMIN \
// -v $(pwd)/criticalcss/src:/home/pptruser/src \
// -v $(pwd)/customer_data:/home/pptruser/customer_data \
// -v /var/run/docker.sock:/var/run/docker.sock \
// critical_criticalcss bash
// critical_criticalcss node runner.js
