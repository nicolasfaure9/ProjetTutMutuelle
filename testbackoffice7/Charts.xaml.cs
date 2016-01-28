using DevExpress.Xpf.Gauges;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;

namespace testbackoffice7
{
    /// <summary>
    /// Logique d'interaction pour Charts.xaml
    /// </summary>
    public partial class Charts : UserControl
    {
        private DataSet2TableAdapters.QueriesTableAdapter querieTA = new DataSet2TableAdapters.QueriesTableAdapter();
        private DataSet2TableAdapters.FORMULETableAdapter formule = new DataSet2TableAdapters.FORMULETableAdapter();
        private DataSet2TableAdapters.SOINSTableAdapter soins = new DataSet2TableAdapters.SOINSTableAdapter();
        private DataSet2TableAdapters.REGIONSTableAdapter region = new DataSet2TableAdapters.REGIONSTableAdapter();
        public DataSet2 dataset;
        private BackgroundWorker bw;
        private bool IsAlreadyComplet = false;
        public Charts()
        {
            InitializeComponent();
            
            dataset = new DataSet2();
            bw = new BackgroundWorker();
            bw.DoWork +=bw_DoWork;
            bw.RunWorkerCompleted +=bw_RunWorkerCompleted;

            //foreach (DataSet2.FORMULERow ele in dataset.FORMULE) 
            //{
            //    decimal? nbtotal;
            //    decimal? restmp;
            //    querieTA.NB_ADHERENT(out nbtotal);
            //    querieTA.NB_ADH_CONTRAT(ele.FORMULE,out restmp);
            //    double resfin = (double)restmp / (double)nbtotal;
            //    adhcontr.Points.Add(new DevExpress.Xpf.Charts.SeriesPoint() {Argument = ele.FORMULE,Value = resfin });
            //}


        }

        private void bw_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
        {
            IsAlreadyComplet = true;
        }

        private void bw_DoWork(object sender, DoWorkEventArgs e)
        {
            region.Fill(dataset.REGIONS);
            formule.Fill(dataset.FORMULE);
            soins.Fill(dataset.SOINS);
            decimal? cares;
            decimal? margeres;
            decimal? rembres;
            decimal? tauxremb;
            decimal? nbprest;
            decimal? nbadh;
            decimal? nbbenefice;
            decimal? txrembours;
            decimal? remboursfemme;
            decimal? rembourshomme;


            querieTA.TAUX_REMBOURSEMENT(out txrembours);
            querieTA.MOYENNE_SOINS_SEXE("M", out rembourshomme);
            querieTA.MOYENNE_SOINS_SEXE("F", out remboursfemme);
            querieTA.NB_ADHERENT(out nbadh);
            querieTA.NB_PRESTA(out nbprest);
            querieTA.CA(out cares);
            querieTA.MARGE(out margeres);
            querieTA.REMBOURSEMENTS(out rembres);
            querieTA.TAUX_REMBOURSEMENT(out tauxremb);
            querieTA.NB_BENEFICIAIRE(out nbbenefice);
            


            //MessageBox.Show(querieTA.MOYENNE_SOINS_SEXE("M").ToString());
            if (txrembours != null) App.Current.Dispatcher.BeginInvoke(new Action(() => { txremb.Needles.Add(new ArcScaleNeedle() {Value =(int)txrembours *100}); }));
            if (remboursfemme != null) App.Current.Dispatcher.BeginInvoke(new Action(() => { rembfemme.Needles.Add(new ArcScaleNeedle() { Value=(int)remboursfemme}); }));
            if (rembourshomme != null) App.Current.Dispatcher.BeginInvoke(new Action(() => { rembhom.Needles.Add(new ArcScaleNeedle() {Value=(int)rembourshomme }); }));

            if (nbprest != null) App.Current.Dispatcher.BeginInvoke(new Action(() => { nbremb.Text = nbprest.ToString(); }));
            if (cares != null) App.Current.Dispatcher.BeginInvoke(new Action(() => { cagauge.Text = cares.ToString(); })); 
            if (margeres != null) App.Current.Dispatcher.BeginInvoke(new Action(() => { margegauge.Text = margeres.ToString(); }));
            if (rembres != null) App.Current.Dispatcher.BeginInvoke(new Action(() => { rembgauge.Text = rembres.ToString(); }));
            if (nbadh != null) App.Current.Dispatcher.BeginInvoke(new Action(() => { nbadher.Text = nbadh.ToString();}));
            if (nbbenefice != null) App.Current.Dispatcher.BeginInvoke(new Action(() => { nbbene.Text = nbbenefice.ToString(); }));
            


            foreach (DataSet2.REGIONSRow elem in dataset.REGIONS)
            {
               
                decimal? restmp;
                querieTA.NB_REMBOURSEMENTS(elem.LIB_REGION, out restmp);
                double resfinal = (double)restmp / (double)nbprest;
              App.Current.Dispatcher.BeginInvoke(new Action(()=>
              {
                  regpie.Points.Add(new DevExpress.Xpf.Charts.SeriesPoint() { Argument = elem.LIB_REGION, Value = resfinal });
              }));  
            }

            foreach (DataSet2.SOINSRow elem in dataset.SOINS)
            {
                decimal? ressoins;
                double resfinal;
                
                querieTA.NB_PRESTA_SOINS(elem.DESIGNATION_ACTE, out ressoins);
                resfinal = (double)ressoins / (double)nbprest;
                if (resfinal > 0.01f)
                {
                    App.Current.Dispatcher.BeginInvoke(new Action(()=>
                    {
                      soinspie.Points.Add(new DevExpress.Xpf.Charts.SeriesPoint() { Argument = elem.DESIGNATION_ACTE, Value = resfinal });
                    }));
                }
            }


        }

        private void Button_Click(object sender, RoutedEventArgs e)
        {
            PrintDialog dlg = new PrintDialog();
            dlg.ShowDialog();
        }

        private void UserControl_Loaded(object sender, RoutedEventArgs e)
        {
            if (bw.IsBusy != true && IsAlreadyComplet == false)
            {
                bw.RunWorkerAsync();
            }
        }
    }
}
