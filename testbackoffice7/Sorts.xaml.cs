using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.IO;
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
    /// Logique d'interaction pour Sorts.xaml
    /// </summary>
    public partial class Sorts : UserControl
    {
        private DataSet2TableAdapters.PRESTATIONS_SANTETableAdapter prest_sant;
        private DataSet2 dataset;
        private BackgroundWorker bw;
        public Sorts()
        {
           InitializeComponent();
            dataset = new DataSet2();
            bw = new BackgroundWorker(){WorkerReportsProgress = true, WorkerSupportsCancellation = true};
            bw.DoWork +=bw_DoWork;
            bw.ProgressChanged +=bw_ProgressChanged;
            bw.RunWorkerCompleted +=bw_RunWorkerCompleted;
            prest_sant = new DataSet2TableAdapters.PRESTATIONS_SANTETableAdapter();
            MaterialDesignThemes.Wpf.PaletteHelper tmp = new MaterialDesignThemes.Wpf.PaletteHelper();
            tmp.ReplacePrimaryColor("blue");
        }

         
        

        private void bw_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
        {
            MessageBox.Show("le fichier csv a ete sauvegarde dans le dossier : "+System.IO.Path.GetDirectoryName(App.ResourceAssembly.Location));   
        }

        private void bw_ProgressChanged(object sender, ProgressChangedEventArgs e)
        {
            progress.Value = e.ProgressPercentage;
        }

        private void bw_DoWork(object sender, DoWorkEventArgs e)
        {
            var file = System.IO.Path.GetDirectoryName(App.ResourceAssembly.Location) + @"\mylittleOutput.csv";
            prest_sant.Fill(dataset.PRESTATIONS_SANTE);

            

            using (var stream = File.CreateText(file))
            {
               int cmpt = 0;
               
                foreach (DataSet2.PRESTATIONS_SANTERow elem in dataset.PRESTATIONS_SANTE)
                {
                    if (cmpt < 5001)
                    {

                        var en = elem.ItemArray.AsEnumerable();
                        string csvrow = "";
                        foreach (var ele in en)
                        {
                            csvrow += ele.ToString() + ";";
                        }
                        csvrow = csvrow.Substring(0, csvrow.Length - 1);

                        stream.WriteLine(csvrow);
                        cmpt++;
                        bw.ReportProgress(cmpt);
                        
                    }
                    
                }

                
            }
            
        }

        private void Button_Click(object sender, RoutedEventArgs e)
        {
            bw.RunWorkerAsync();
        }

        private void UserControl_Loaded(object sender, RoutedEventArgs e)
        {

        }
    }
}
