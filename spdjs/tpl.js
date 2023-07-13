

taskExecCount = 2;
child_process = require('child_process')
for (var i = 0; i < taskExecCount; i++) {
    var cmd = 'node ./geneListPageFiles.js ' + taskExecCount + " " + i;
    console.log(cmd)
    child_process.exec(cmd, function (error, stdout, stderr) {
        if (error) {
            console.error('error: ' + error);
            return;
        }
        console.log('stdout: ' + stdout);
        console.log('stderr: ' + typeof stderr);
    });
}


