#!/bin/bash
set -e

# import variables
jobdir=$(realpath $1)
pyscript=$(realpath $2)
jobid=$(basename $jobdir | sed 's/job_//')

# set environmental variables
source .profile

cd $jobdir

# run rhapsody
$PYTHON $pyscript > rhapsody-log.txt 2>&1

# send notification when done (if email address is found)
if [ -e input-email.txt ]; then
  # email=$(cat input-email.txt)
  email="ponzoniluca@gmail.com, $(cat input-email.txt)"
else
  email="ponzoniluca@gmail.com"
fi

sendmail -t <<EOF
To: ${email}
Subject: Rhapsody: job ${jobid} completed!
MIME-Version: 1.0
Content-type: text/html; charset=UTF-8
From: Rhapsody Webserver <dcb@pitt.edu>

<html>
<head>
<title>Rhapsody</title>
</head>
<body>
<p>Click <a href="http://rhapsody.csb.pitt.edu/results.php?id=${jobid}">here</a>
to access the results page.</p>
</body>
</html>
EOF


exit 0