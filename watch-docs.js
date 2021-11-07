const chokidar = require('chokidar');
const path     = require('path');
const {exec}   = require("child_process");

chokidar.watch(path.join(__dirname, 'resources', 'docs'), {ignoreInitial : true}).on('all', (event, path) => {
    console.log('Change detected... running docs:process');

    exec("php artisan docs:process", (error, stdout, stderr) => {
        if (error) {
            console.log(`error: ${error.message}`);
            return;
        }
        if (stderr) {
            console.log(`stderr: ${stderr}`);
            return;
        }

    });
});
