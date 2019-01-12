import sys
import os.path
from datetime import datetime
from glob import glob
from zipfile import ZipFile
import config
sys.path.insert(0, config.PRODY_DIR)
sys.path.append(config.RHAPSODY_DIR)
from prody import LOGGER
from rhapsody import *


LOGGER.info(f'started on   {datetime.now()}')
LOGGER.info('')

# temporarily change pickle folder location
orig_pickle_folder = pathRhapsodyFolder()
orig_verbosity = LOGGER.verbosity
LOGGER._setverbosity('none')
pathRhapsodyFolder(config.PICKLES_DIR)
LOGGER._setverbosity(orig_verbosity)

# import data
with open('input-sm_query.txt', 'r') as f:
    input_query = f.read()
if os.path.isfile('input-PDBID.txt'):
    with open('input-PDBID.txt', 'r') as f:
        pdb = f.read()
elif os.path.isfile('input-PDB.pdb'):
    pdb = 'input-PDB.pdb'
elif os.path.isfile('input-PDB.pdb.gz'):
    pdb = 'input-PDB.pdb.gz'
else:
    pdb = None

# run RHAPSODY
rh = rhapsody(input_query, config.MAIN_CLSF, aux_classifier=config.AUX_CLSF,
              input_type='scanning', custom_PDB=pdb)

# restore original pickle folder location
if orig_pickle_folder is not None:
    v = LOGGER.verbosity
    LOGGER._setverbosity('none')
    pathRhapsodyFolder(orig_pickle_folder[0])
    LOGGER._setverbosity(v)

LOGGER.info('')
LOGGER.info(f'completed on {datetime.now()}')

# zip results
files = glob('rhapsody-*txt') + glob('pph2-*txt')
with ZipFile('rhapsody-results.zip','w') as zip:
        for file in files:
            zip.write(file)
