import os
import time
import datetime
import glob
import zipfile
import prody as pd
from prody import LOGGER
import rhapsody as rd
import protocols


DEBUG_MODE = False

LOGGER._setprefix('')
LOGGER.info(f'Started on   {datetime.datetime.now()}')
LOGGER.info('')

# set PDB folder
old_verbosity = LOGGER.verbosity
LOGGER._setverbosity('none')
home_dir = os.environ['HOME']
pdb_dir = os.path.join(home_dir, 'PDBs')
if not os.path.isdir(pdb_dir):
    os.mkdir(pdb_dir)
pd.pathPDBFolder(pdb_dir)
LOGGER._setverbosity(old_verbosity)

# check Rhapsody installation
rd.initialSetup()

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
LOGGER.info(f'Completed on {datetime.datetime.now()}')

# zip results
files = glob.glob('rhapsody-*') + glob.glob('pph2-*txt')
with zipfile.ZipFile('rhapsody-results.zip', 'w') as zip:
    for file in files:
        zip.write(file)
