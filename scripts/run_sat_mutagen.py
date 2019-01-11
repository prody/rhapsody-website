import sys
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

# run RHAPSODY
rh = rhapsody(input_query, config.MAIN_CLSF, aux_classifier=config.AUX_CLSF,
              input_type='scanning')

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
