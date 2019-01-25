import matplotlib
import pylab
matplotlib.rcParams.update({'font.size': 20, 'font.family': 'Arial'})



fig = pylab.figure()
figlegend = pylab.figure(figsize=(8,1))
ax = fig.add_subplot(111)
xs = range(10)
l  = ax.plot(xs, pylab.randn(10), 'ro-')
l += ax.plot(xs, pylab.randn(10), 'ro-', markerfacecolor='none', ls='dotted')
l += ax.plot(xs, pylab.randn(10), color='blue',  lw=.5)
l += ax.plot(xs, pylab.randn(10), color='green', lw=.5)
figlegend.legend(l, ('Rhapsody (full classifier)',
                     'Rhapsody (reduced classifier)',
                     'PolyPhen-2', 'EVmutation'),
                     'center', ncol=2)

figlegend.savefig('../../img/sm_legend.png', format='png', bbox_inches='tight', dpi=300)

