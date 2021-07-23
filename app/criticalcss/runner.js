const puppeteer = require('puppeteer');
const fs = require('fs');
const penthouse = require('penthouse');
const argv = require('minimist')(process.argv.slice(2));

(async () => {
    const browser = await puppeteer.launch({
        executablePath: 'google-chrome-stable',
        args: [
            '--disable-dev-shm-usage', // https://github.com/puppeteer/puppeteer/blob/main/docs/troubleshooting.md#tips
        ],
    });

    const {
        tmp_bundled_css_filename,
        tmp_critical_css_filename,
        tmp_dir,
        page_url,
    } = argv;

    const page = await browser.newPage();
    const bundledCssFile = `${tmp_dir}/${tmp_bundled_css_filename}`;
    const criticalCssFile = `${tmp_dir}/${tmp_critical_css_filename}`;

    page.on('response', async response => {
        if (response.request().resourceType() !== 'stylesheet') return;
        fs.appendFileSync(bundledCssFile, await response.text());
    });

    await page.goto(page_url);
    await browser.close();

    penthouse({
        url: page_url,
        css: bundledCssFile,
        // cssString: 'body { color: red }'
    }).then(criticalCss => {
        fs.writeFileSync(criticalCssFile, criticalCss);
    })
})();

// docker run -it --init --rm --cap-add=SYS_ADMIN \
// -v $(pwd)/criticalcss/src:/home/pptruser/src \
// -v $(pwd)/customer_data:/home/pptruser/customer_data \
// -v /var/run/docker.sock:/var/run/docker.sock \
// critical_criticalcss bash
// critical_criticalcss node runner.js
