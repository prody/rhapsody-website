import datetime
import sys
import config
sys.path.insert(0, config.PRODY_DIR)
sys.path.append(config.RHAPSODY_DIR)
from rhapsody import *


with open('status.txt', 'w') as f:
    f.write(f'started on   {datetime.datetime.now()} \n')

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
    pathRhapsodyFolder(orig_pickle_folder[0])

with open('status.txt', 'a') as f:
    f.write(f'completed on {datetime.datetime.now()} \n')
