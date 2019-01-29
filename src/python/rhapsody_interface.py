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


if DEBUG_MODE:
    time.sleep(5)
else:
    main_clsf = realpath(os.environ['MAIN_CLSF'])
    aux_clsf  = realpath(os.environ['AUX_CLSF'])
    EVmut_cutoff = float(os.environ['EVMUT_CUTOFF'])

    # run appropriate protocol
    if isfile('input-sm_query.txt'):
        # perform saturation mutagenesis
        rh = sat_mutagen(main_clsf, aux_clsf, EVmut_cutoff)
    elif isfile('input-batch_query.txt'):
        # analyse batch query
        rh = batch_query(main_clsf, aux_clsf)
    else:
        raise ValueError('Invalid protocol')

    # print EVmutation predictions to file
    EVscore = rh.calcEVmutationFeats()['EVmut-DeltaE_epist']
    SAVs = rh.SAVcoords['text']
    with open('rhapsody-EVmutation.txt', 'w') as f:
        f.write('# SAV coords           score     prob    class \n')
        for SAV, s in zip(SAVs, EVscore):
            # compute "normalized" score
            ns = s/EVmut_cutoff*0.5
            if s > 0.5:
                c = 'deleterious'
            elif s < 0.5:
                c = 'neutral'
            else:
                c = '-'
            f.write(f'{SAV:22} {s:<7.3f}   {ns:<5.3f}   {c:12s} \n')


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
