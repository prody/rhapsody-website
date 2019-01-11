import datetime
import sys
import config
sys.path.insert(0, config.PRODY_DIR)
sys.path.append(config.RHAPSODY_DIR)
from prody import LOGGER
from rhapsody import *


start_time = datetime.datetime.now()

# temporarily change pickle folder location
orig_pickle_folder = pathRhapsodyFolder()
pathRhapsodyFolder(config.PICKLES_DIR)

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

with open('rhapsody-info.txt', 'w') as f:
    f.write(f'started on   {start_time} \n')
    f.write(f'completed on {datetime.datetime.now()} \n')
