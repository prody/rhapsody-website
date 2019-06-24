from os.path import isfile, isdir, basename, join
from shutil import copyfile
from glob import glob
from rhapsody import *

FIGURE_MAX_WIDTH = 100


def sat_mutagen(main_clsf, aux_clsf, EVmut_cutoff):

    # import data
    with open('input-sm_query.txt', 'r') as f:
        input_query = f.read().strip()
    if isfile('input-PDBID.txt'):
        with open('input-PDBID.txt', 'r') as f:
            pdb = f.read()
    elif isfile('input-PDB.pdb'):
        pdb = 'input-PDB.pdb'
    elif isfile('input-PDB.pdb.gz'):
        pdb = 'input-PDB.pdb.gz'
    else:
        pdb = None

    # run RHAPSODY
    if isfile('pph2-full.txt'):
        rh = rhapsody('pph2-full.txt', main_clsf, aux_classifier=aux_clsf,
                      input_type='PolyPhen2', custom_PDB=pdb, log=False)
    else:
        rh = rhapsody(input_query, main_clsf, aux_classifier=aux_clsf,
                      input_type='scanning', custom_PDB=pdb, log=False)

    # create figure(s)
    num_res = len(set(rh.SAVcoords['pos']))
    if num_res <= FIGURE_MAX_WIDTH:
        print_sat_mutagen_figure('rhapsody-figure.png', rh,
        EVmut_cutoff=EVmut_cutoff, html=True)
    else:
        num_splits = int(num_res/FIGURE_MAX_WIDTH) + 1
        n = int(num_res/num_splits)
        remainder = num_res%num_splits
        for i in range(num_splits):
            interval = (i*n+1, (i+1)*n+remainder)
            fname = f'rhapsody-figure_{i+1}.png'
            print_sat_mutagen_figure(fname, rh, res_interval=interval,
            EVmut_cutoff=EVmut_cutoff, html=True)

    return rh


def batch_query(main_clsf, aux_clsf):

    # import data
    with open('input-batch_query.txt', 'r') as f:
        input_query = f.read().strip()

    # run RHAPSODY
    if isfile('pph2-full.txt'):
        rh = rhapsody('pph2-full.txt', main_clsf, aux_classifier=aux_clsf,
                      input_type='PolyPhen2', log=False)
    else:
        rh = rhapsody('input-batch_query.txt', main_clsf,
                      aux_classifier=aux_clsf, log=False)

    return rh


