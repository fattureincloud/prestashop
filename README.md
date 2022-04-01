# fattureincloud/prestashop v2

Modulo Prestashop per Fatture in Cloud.

## Compatibilità

Questo modulo è compatibile con versioni **uguali o superiori alla 1.7.6** di Prestashop.

| Versione fattureincloud/prestashop | Versione Prestashop richiesta |
| ---------------------------------- | ----------------------------- |
| 2.0.x                              | 1.7.6 o superiore             |

## Funzionalità

* Creazione automatica degli ordini
* Scarico automatico prodotti dal magazzino
* Creazione automatica delle fatture
* Invio delle fatture al sistema di interscambio
* Aggiornamento automatico delle anagrafiche cliente su Fatture in Cloud
* Aggiunta dei campi Email PEC e Codice SDI alle anagrafiche dei clienti
* Associazione aliquote IVA tra Prestashop e Fatture in Cloud


## Installazione

L’installazione del modulo è molto semplice! Segui i seguenti passi:

* Scarica il file ZIP dalla [pagina delle release](https://github.com/fattureincloud/prestashop/releases/)
* Vai nella sezione *Gestione Moduli* del pannello di amministrazione del tuo negozio Prestashop
* Clicca su *Carica un modulo* in alto a destra
* Trascina il file ZIP scaricato in precedenza nella finestra di caricamento
* Attendi che il modulo sia installato. Ora puoi connettere il tuo account di Fatture in Cloud.


## Connessione

Una volta che il modulo è installato devi connetterlo al tuo account di Fatture in Cloud. Più seguire le istruzioni mostrate a schermo oppure queste istruzioni:

* Accedi alla configurazione del modulo (se lo hai appena installato clicca su *Configura* al termine dell’installazione)
* Nel primo passo della configurazione ti verrà fornito un codice, ricopialo e apri l’url [https://secure.fattureincloud.it/connetti](https://secure.fattureincloud.it/connetti) (in una nuova finestra / tab del tuo browser)
* Incolla il codice che hai copiato nel punto precedente e clicca su *Continua*
* Conferma il processo cliccando su *Autorizza* (eventualmente puoi selezionare l’azienda a cui il modulo avrà accesso)
* Torna sul tuo negozio e ti verrà mostrato l’elenco delle aziende collegate al tuo account. Scegli quella che vuoi connettere (e che hai autorizzato nel punto precedente).
* Il tuo account è collegato! Ora puoi configurare il modulo.


## Configurazione

### Configurazione principale

Una volta connesso il tuo account di Fatture in Cloud puoi configurare le varie opzioni disponibili cliccando sul tasto *Configura* corrispondente al modulo nella sezione *Gestione Moduli* del pannello di amministrazione del tuo negozio.

Ecco tutte le opzioni disponibili:

**Centro di ricavo** (opzionale): specifica il centro di ricavo che verrà utilizzato per gli ordini e/o le fatture in arrivo dal negozio.

**Crea ordini** (opzionale): attiva o disattiva la creazione degli ordini su Fatture in Cloud quando arriva un nuovo ordine al negozio.

**Sezionale ordini** (opzionale): la numerazione/sezionale che vuoi utilizzare per gli ordini provenienti dal negozio.

**Scarica magazzino da ordine** (opzionale): attiva o disattiva lo scarico automatico dal magazzino di Fatture in Cloud per i prodotti presenti nell’ordine in arrivo dal negozio.

**Crea fatture** (opzionale): attiva o disattiva la creazione delle fatture su Fatture in Cloud quando un ordine indicato come pagato sul negozio.

**Invia fatture elettroniche** (opzionale): invia automaticamente al sistema di interscambio le fatture elettroniche.

**Sezionale fatture** (opzionale): la numerazione/sezionale che vuoi utilizzare per le fatture emesse per gli ordini provenienti dal negozio.

**Aggiorna anagrafica cliente** (opzionale): aggiorna in automatico le anagrafiche cliente presenti su Fatture in Cloud con i dati del cliente in arrivo dal negozio. *N.B.: se non vuoi che i dati del cliente presenti su Fatture in Cloud siano sovrascritti da quelli presenti su Prestashop, non attivare questa opzione.*

Ricordati di cliccare su *Salva configurazioni* quando hai impostato tutte le opzioni.

### Configurazione Aliquote IVA

Di base il modulo utilizza già le aliquote IVA standard di FattureInCloud. Se vuoi personalizzarle, modificarle o utilizzare aliquote IVA particolari segui queste istruzioni:

* Assicurati che l’aliquota IVA sia creata sia su Fatture in Cloud che sul negozio
* Nel pannello di amministrazione del tuo negozio vai su *Internazionale > Tasse*
* Individua l’aliquota IVA che vuoi collegare a Fatture in Cloud ed accedi alla sua modifica
* Utilizza il campo *Corrispondenza in *FattureInCloud* per selezionare l’aliquota corrispondente
* Clicca su *Salva* per confermare la scelta.


## Supporto

Se hai bisogno di assistenza o hai richieste riguardo questo modulo contatta Fatture in Cloud tramite la chat di supporto presente sulla piattaforma.


## Feature request e bug report

Se desideri segnalare un problema con questo modulo o proporre una feature mancante puoi utilizzare la sezione [Issue](https://github.com/fattureincloud/prestashop/issues).
