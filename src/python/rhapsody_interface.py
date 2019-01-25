import sys, os, time
from os.path import realpath, isfile, isdir
from datetime import datetime
from glob import glob
from zipfile import ZipFile
import numpy as np
# use environmental variables
sys.path.insert(0, realpath(os.environ['PRODY_DIR']))
sys.path.append(realpath(os.environ['RHAPSODY_DIR']))
from prody import LOGGER, pathPDBFolder
from rhapsody import *
from protocols import sat_mutagen, batch_query


DEBUG_MODE = False


LOGGER._setprefix('')
LOGGER.info(f'started on   {datetime.now()} \n')
LOGGER.info('')
old_verbosity = LOGGER.verbosity


# temporarily change pickle and PDB folder locations,
# set EVmutation folder
LOGGER._setverbosity('none')
old_pickle_folder = pathRhapsodyFolder()
old_PDB_folder    = pathPDBFolder()
pathRhapsodyFolder(  realpath(os.environ['PICKLES_DIR']))
pathPDBFolder(       realpath(os.environ['PDB_DIR']))
pathEVmutationFolder(realpath(os.environ['EVMUT_DIR']))
LOGGER._setverbosity(old_verbosity)



if not DEBUG_MODE:
    main_clsf = realpath(os.environ['MAIN_CLSF'])
    aux_clsf  = realpath(os.environ['AUX_CLSF'])

    # run appropriate protocol
    if isfile('input-sm_query.txt'):
        # perform saturation mutagenesis
        rh = sat_mutagen(main_clsf, aux_clsf)
    elif isfile('input-batch_query.txt'):
        # analyse batch query
        rh = batch_query(main_clsf, aux_clsf)
    else:
        raise ValueError('Invalid protocol')

    # print EVmutation features to file
    np.savetxt('rhapsody-EVmutation.txt', rh.calcEVmutationFeats(), fmt='%10.3e')


# restore original pickle and PDB folder locations
LOGGER._setverbosity('none')
if old_pickle_folder is None or not isdir(old_pickle_folder[0]):
    pathRhapsodyFolder('')
else:
    pathRhapsodyFolder(old_pickle_folder[0])
if old_PDB_folder is None or not isdir(old_PDB_folder[0]):
    pathPDBFolder('')
else:
    pathPDBFolder(old_PDB_folder[0])
LOGGER._setverbosity(old_verbosity)


LOGGER.info('')
LOGGER.info(f'completed on {datetime.now()}')


# zip results
files = glob('rhapsody-*') + glob('pph2-*txt')
if glob('pph2-*txt'):
    files.remove('pph2-started.txt')
    files.remove('pph2-completed.txt')
with ZipFile('rhapsody-results.zip','w') as zip:
        for file in files:
            zip.write(file)
