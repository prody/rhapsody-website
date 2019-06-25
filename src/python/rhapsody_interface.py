import os
import time
import datetime
import glob
import zipfile
from prody import LOGGER
import rhapsody as rd
import protocols


DEBUG_MODE = False

LOGGER._setprefix('')
LOGGER.info(f'started on   {datetime.datetime.now()}')
LOGGER.info('')

# run setup
# old_verbosity = LOGGER.verbosity
# LOGGER._setverbosity('none')
rd.initialSetup()
LOGGER.info('')
# LOGGER._setverbosity(old_verbosity)

if DEBUG_MODE:
    time.sleep(5)
else:
    # run appropriate protocol
    if os.path.isfile('input-sm_query.txt'):
        # perform saturation mutagenesis
        rh = protocols.sat_mutagen()
    elif os.path.isfile('input-batch_query.txt'):
        # analyse batch query
        rh = protocols.batch_query()
    else:
        raise ValueError('Invalid protocol')

LOGGER.info('')
LOGGER.info(f'completed on {datetime.datetime.now()}')

# zip results
files = glob.glob('rhapsody-*') + glob.glob('pph2-*txt')
if glob.glob('pph2-*txt'):
    files.remove('pph2-started.txt')
    files.remove('pph2-completed.txt')
with zipfile.ZipFile('rhapsody-results.zip', 'w') as zip:
    for file in files:
        zip.write(file)
