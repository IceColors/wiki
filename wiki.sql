-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 18, 2020 at 08:23 PM
-- Server version: 8.0.18
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wiki`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `ArticleID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `Privilige` varchar(55) NOT NULL DEFAULT 'default',
  `startdate` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `enddate` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `importance` int(11) NOT NULL,
  PRIMARY KEY (`ArticleID`),
  UNIQUE KEY `ArticleID` (`ArticleID`),
  KEY `CategoryID` (`CategoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`ArticleID`, `Name`, `CategoryID`, `Privilige`, `startdate`, `enddate`, `importance`) VALUES
(1, 'Opphavsmytene', 21, 'default', '-07530421', '-07530421', 0),
(2, 'Monarkiet', 22, 'default', '-07530421', '-0509', 0),
(3, 'Den eldre republikken', 23, 'default', '-0509', '-0300', 1),
(4, 'Den klassiske republikken', 24, 'default', '-0300', '-0130', 2),
(5, 'Senrepublikken', 25, 'default', '-0130', '+0031', 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `CategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `ParentID` int(11) DEFAULT NULL,
  `Privilige` varchar(55) NOT NULL DEFAULT 'default',
  PRIMARY KEY (`CategoryID`),
  UNIQUE KEY `CategoryID` (`CategoryID`),
  KEY `ParentID` (`ParentID`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`CategoryID`, `Name`, `ParentID`, `Privilige`) VALUES
(1, 'Romerrikets historie', NULL, 'default'),
(21, 'Opphavsmyte', 1, 'default'),
(22, 'Monarkiet', 1, 'default'),
(23, 'Den eldre republikken', 1, 'default'),
(24, 'Den klassiske republikken', 1, 'default'),
(25, 'Senrepublikken', 1, 'default');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `MediaID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Privilige` varchar(55) NOT NULL DEFAULT 'default',
  `Path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Description` text,
  PRIMARY KEY (`MediaID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`MediaID`, `Name`, `UserID`, `Timestamp`, `Privilige`, `Path`, `Description`) VALUES
(1, 'Romulus og Remulus', 1, '2020-03-10 18:08:44', 'default', '/media/standard_Romulus_and_Remus.jpg', 'følge Romas opphavsmyte ble byen grunnlagt av tvillingbrødrene Romulus og Remus, som ifølge sagnet ble oppfostret av en ulv.'),
(2, 'Forum Romanum', 1, '2020-03-10 18:09:42', 'default', '/media/standard_Forum_Romanum_through_Arch_of_Septimius_Severus_Forum_Romanum_Rome.jpg', 'Forum Romanum vokste frem i Romas tidligste tid. Siden var plassen kontinuerlig i bruk som monumentalt bysentrum gjennom tusen år, og utviklet seg i takt med romerstatens historie ned til antikkens  slutt.'),
(3, 'Kart over rommerrikets erobringer', 1, '2020-03-10 18:10:44', 'default', '/media/standard_standard_1_romerriket-2.png', 'Romernes erobringer ca. 200 fvt.–ca. 200 evt.'),
(4, 'Gaius Marius', 1, '2020-03-10 18:11:44', 'default', '/media/standard_Marius__GL_319__-_Glyptothek_-_Munich_-_Germany_2017.jpg', 'Gaius Marius ble ansett som Romerrikets redningsmann etter alle seirene over germanerne.'),
(5, 'Augustus', 1, '2020-03-10 18:12:18', 'default', '/media/standard_Augustus_500px.jpg', 'Prinsipat 1. Keiser Augustus, samtidig marmorskulptur fra Antiokia i Lilleasia. Det arkeologiske museum, Istanbul.'),
(6, 'Marcus Aurelius', 1, '2020-03-10 18:13:00', 'default', '/media/standard_Markaurel550px.jpg', 'Prinsipat 2. Filosofkeiseren Marcus Aurelius er den eneste romerske keiser som det finnes bevart en samtidig rytterstatue av. Bronsestatuer av de hedenske keisere ble smeltet om i kristen tid. Statuen står i Kapitolmuseet; en kopi står ute på Kapitolplassen.');

-- --------------------------------------------------------

--
-- Table structure for table `revisions`
--

DROP TABLE IF EXISTS `revisions`;
CREATE TABLE IF NOT EXISTS `revisions` (
  `RevisionID` int(11) NOT NULL AUTO_INCREMENT,
  `ArticleID` int(11) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `EditType` varchar(55) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TextID` int(11) NOT NULL,
  `mediaID` int(11) DEFAULT NULL,
  PRIMARY KEY (`RevisionID`),
  UNIQUE KEY `RevisionID` (`RevisionID`),
  UNIQUE KEY `TextID` (`TextID`),
  KEY `ArticleID` (`ArticleID`),
  KEY `mediaID` (`mediaID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `revisions`
--

INSERT INTO `revisions` (`RevisionID`, `ArticleID`, `Date`, `EditType`, `UserID`, `TextID`, `mediaID`) VALUES
(2, 1, '2020-02-21 20:42:33', 'creation', 1, 1, 1),
(3, 3, '2020-02-21 20:52:51', 'creation', 1, 2, 2),
(4, 4, '2020-02-21 20:53:04', 'creation', 1, 3, 3),
(5, 5, '2020-02-21 20:53:18', 'creation', 1, 4, 4),
(6, 2, '2020-02-24 15:02:48', 'creation', 1, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `text`
--

DROP TABLE IF EXISTS `text`;
CREATE TABLE IF NOT EXISTS `text` (
  `TextID` int(11) NOT NULL AUTO_INCREMENT,
  `Content` text,
  PRIMARY KEY (`TextID`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `text`
--

INSERT INTO `text` (`TextID`, `Content`) VALUES
(1, 'Roma var byen på de sju høyder: Kapitol, Palatinen, Aventinen, Caelius, Esquilinen, Viminalen og Quirinalen. Etter tradisjonen ble byen grunnlagt av Romulus i 753 fvt., ifølge den senrepublikanske kronologien fastsatt av Varro.\r\n\r\nDet er arkeologiske spor av graver på Forum og bosetninger på høydene som kan dateres enda tidligere, men vi kan neppe snakke om en skikkelig by før på 600-tallet, hvor sumpområdene mellom høydene var blitt tørrlagt og lagt ut til offentlig torg, Forum Romanum. Stedet lå strategisk godt til ved et naturlig vadested over elva Tiber (moderne Tevere) og langs ferdselsåren fra fjellene og ned til sjøen. Dette er med på å forklare byens vekst.\r\n\r\nRoma ble etter tradisjonen først styrt av sju konger, men de skriftlige kildene vi har til den tidligste historien er upålitelige. Beretningen om Romulus og de neste tre kongene – Numa, Tullus Hostilius og Ancus Marcius – er særlig omstridt. Beskrivelsen kildene gir av Roma som et slags etablert fristed for omflakkende lykkejegere under den tidlige kongetiden, kan være riktig og forklare den tilsynelatende dynamiske og ekspansive byen. På 500-tallet framstår byen som en maktfaktor i Latium.\r\n\r\nMed Tarquinius Priscus kom en periode med et etruskisk dynasti på tronen, som videreføres under Servius Tullius og Tarquinius Superbus. Den siste tarquineren skal ha blitt fordrevet i 510 eller 509 fvt. Dateringen og hendelsene rundt er omstridt, da de faller sammen med og beskrives likt som tyrannveldets fall i Athen.\r\n\r\nEn mann med et typisk romersk navn, Junius Brutus, spilte en hovedrolle ved Tarquinius\' fordrivelse, og det er naturlig å se hendelsen som et uttrykk for at den etruskiske innflytelsen i Roma stoppet opp. Fordi kongene hadde misbrukt sin makt, utformet romerne en styreform som skulle trygge folket mot maktmisbruk fra enkeltmenns side og la flere slekter få ta del i det felles anliggende, res publica. Vi kjenner systemet og perioden det eksisterte derfor som republikken.'),
(2, 'Den eldre republikken var preget av indre strid og ytre krig. Sosial uro, gjeldsslaveri, vilkårlig rettspleie og avgrenset tilgang til politiske posisjoner stod i sentrum for de såkalte stenderkampene mellom de aristokratiske slektene patrisiere og folket, kjent som plebeiere.\r\n\r\nGjennom disse kampene, som foregikk helt til ca. 300 fvt., ble politiske og religiøse maktposisjoner gradvis gjort tilgjengelig for andre enn de patrisiske slektene. Samtidig med denne indre striden kjempet romerne utad både mot nabobyer i Latium og Etruria og invaderende fjellfolk som sabinere, ekvere og volskere. I 390 ble Roma angrepet av gallere (keltere). Etter måneders beleiring måtte romerne, som hadde tatt sin tilflukt til Kapitol, overgi seg og betale gallerne for å få dem til å forlate byen; et nederlag romerne aldri glemte.\r\n\r\nDet nærmeste hundreåret brukte romerne til å nedkjempe sine naboer, i første rekke latinerne og etruskerne. Etter en seier over et forbund av andre latinerstater, etablerte Roma i 338 fvt. en ordning hvor forbundet ble oppløst og alle bystatene fikk individuelle avtaler med Roma. Noen fikk full borgerrett og ble innlemmet i bystaten Roma. Andre fikk avgrenset borgerrett og en viss selvråderett, mens andre igjen fikk beholde selvstendigheten, men pålagt å være Romas forbundsfeller.\r\n\r\nAlle måtte yte militær støtte til romerne. Det bandt alle latinerne til Roma og hindret dem i selvstendige avtaler med hverandre. Systemet ga Roma fleksibilitet og kontroll over store ressurser uten store kostnader. Dette var et utmerket grunnlag for, og oppskrift på, videre ekspansjon.'),
(3, 'Den klassiske republikken er en moderne betegnelse for den tiden da republikken virket etter forutsetningene og ga intern ro og ytre ekspansjon. Det vil si at det republikanske systemet hadde funnet sin form og at det tilsynelatende hersket en konsensus mellom de politiske slektene, senatet og folket om maktutøvelse, krigsinnsats og fordelingspolitikk.\r\n\r\nEtter Pyrrhoskrigen (280-272) hadde romerne erobret hele det sørlige Italia. Med herredømmet over de greske bystatene der ble gresk innflytelse mer tydelig i den romerske kulturen. Romernes ekspanderende makt utfordret imidlertid karthagerne som kontrollerte Sicilia. Etter den første (264–241) og den andre (218–201) punerkrigen ble Roma den dominerende makt i hele det vestlige Middelhavet, men særlig den andre krigen var en stor påkjenning for romerne. De led mange nederlag mot Hannibal og hans tropper, de mest kjente ved Trasimenersjøen i Umbria (217) og Cannae i Sør-Italia (216).\r\n\r\nHannibalskrigen ble hovedsakelig ført på italiensk jord, og store deler av Sør-Italia ble herjet og ødelagt. Romernes endelige seier skyldes utholdenhet; Scipio Africanus\' innsats i Spania og det faktum at romernes forbundsfeller ikke gikk over til Hannibal i den utstrekning han hadde forventet. Den tredje puniske krig (149–146) utslettet gamle Karthago som by.\r\n\r\nFra 200 fvt. vendte romerne sin interesse mot øst og blandet seg i den hellenistiske stormaktspolitikken. Etter en serie kriger overtok Roma kontrollen over store deler av den hellenistiske verden. De beseirede statene ble først gjort til forbundsfeller, eller romerske klientstater, men seinere annektert som provinser.\r\n\r\nÅrsakene til romernes ekspansjon i denne perioden har vært livlig diskutert. Flere historikere har betegnet romersk ekspansjon som «defensiv imperialisme» – at krigene ofte blir tvunget på romerne eller at de blir påkalt av én av partene i en strid. Argumentet er også at romerne tilsynelatende vegret seg for å styre overvunne områder direkte, og at anneksjon kun ble en utvei når andre former for maktutøvelse hadde vist seg ikke å være tilstrekkelige. Men det er også dem som mener Roma svarer godt til Joseph Shumpeters beskrivelse av en «krigsmaskin», en organisme skapt av kriger, som ender med å skape kriger. Den tydelige militarismen fra byens begynnelse kombinert med krigsdynamikken i romersk politikk og higen etter militær ære underbygger dette.\r\n\r\nKrigene sikret Roma inntekter i form av krigsbytte og krigsskadeerstatning. Og man trengte heller ikke annektere fremmed land for å dominere politikken og kontrollere ressursene der. Tidligere sammenlignet man også den romerske imperialismen med mer moderne imperiebygging, hvor kontrollen med handelen var viktig. Men slike motiver er det mindre vanlig å tillegge romerne i dag, ettersom den antikke økonomien ikke var så utviklet og statene ikke drev merkantilistisk politikk. Romerstaten utviklet aldri en økonomisk politikk i slik forstand.\r\n\r\nDe oversjøiske krigene på 100-tallet fikk vidtrekkende betydning for Roma og Italia. Kjernen i hæren var Italias frie bondestand, romere og forbundsfeller. Krig var stort sett en sommerbeskjeftigelse i antikken, og under erobringen av Italia kunne soldatene skjøtte sine gårdsbruk i den tiden de ikke lå i felten. Men på 100-tallet førte krigene til at de ofte ikke var hjemme på flere år; de lå i vinterleir i fremmed land og ble mer profesjonalisert som soldater. Det kunne føre til at gårdene ble forsømt. Erobret statsjord (ager publicus), som det ble mye av i Sør-Italia etter Hannibalskrigen, var hovedsakelig forpaktet bort til rikfolk. Rikdommene fra krigene i øst havnet dessuten for en stor grad også på de samme hendene. Ettersom jord var det anerkjente investeringsobjekt i antikken førte dette til at eliten investerte alt mer i jord og etablerte store slavedrevne gods, kjent som latifundia.\r\n\r\nDe nye provinsene betalte mye av sine skatter i form av korn, og jordbruket i Italia ble delvis omlagt til mer spesialisert og kapitalkrevende produksjon, med varer som olivenolje, vin og storfe. Den store slavetilgangen etter seirene på slagmarken betydde billig arbeidskraft på godsene, og i tillegg fikk romerne innpass på de store slavemarkedene i Øst-Middelhavet, som Delos. Man har ment at dette var med å presse deler av den selvstendige bondestanden vekk fra jorda, men nyere undersøkelser tyder på at landsbygda ikke var så avfolket som kildene kan gi inntrykk av. Det var uansett mange som også ble trukket til den voksende storbyen Roma og det urbane livet der. Resultatet var at mange endte opp blant Romas eiendomsløse proletariat. Dette medførte uro og sosiale problemer i byen, og dermed kom forslag om jordreformer og omfordeling av ager publicus høyere opp på den politiske dagsorden.'),
(4, 'Senrepublikken, også kalt revolusjonshundreåret eller borgerkrigstiden, var preget av dyptgående forandringer på det sosiale, økonomiske, kulturelle og politiske området. Tiberius Gracchus, folketribun i 133, forsøkte å motvirke proletariseringen ved å foreslå maksimumsgrenser for hvor mye statsjord, ager publicus, en romer kunne forpakte. Det dreide seg om offentlig eid jord, for en stor del inndradd fra frafalne forbundsfeller under annen punerkrig, men to generasjoner etter krigens slutt var grensene mellom privat og offentlig jord uklar. På den frigitte jorden skulle det opprettes små gårdsbruk for de eiendomsløse. Forslaget ville også bedre rekrutteringsgrunnlaget for hæren, da eiendomsløse ikke kunne rekrutteres som legionærer.\r\n\r\nTiberius gikk rett til folkeforsamlingen med forslaget, og da folketribunkollegaen Octavius nedla veto mot det, gikk han til det revolusjonære skritt å få Octavius avsatt. Etter dette ble forslaget vedtatt. Da Tiberius mot sedvanen søkte gjenvalg som folketribun, utløste det tumulter og han ble drept sammen med flere av sine tilhengere. Dette er blitt stående som symbolet på den brutte politiske konsensusen i republikken, hvor våpenmakt og vold ble introdusert og skillet mellom folket (populus) og senatet ble tydeliggjort. Tiberius blir stående som den første virkelige popularis, en politiker som utfordrer senatet og frir til folket med politiske og økonomiske reformer.\r\n\r\nTiberius\' bror Gaius ble valgt til folketribun for 123. Hans reformer var mer omfattende enn sin brors. Han fornyet jordloven og fikk vedtatt en lov om korn til under markedspris for Romas innbyggere. Senatets makt ble svekket på forskjellig vis, blant annet ved at ridderne fikk domsmyndighet i saker som gjaldt maktmisbruk i provinsene. Hans forslag om å gi forbundsfellene borgerrett møtte stor motstand, og også Gaius fikk en voldsom død. Gracchernes ettermæle i romersk historisk tradisjon er negativ, men ettertiden har bedømt dem svært forskjellig, ofte ut fra historikernes eget politiske ståsted. Et viktig poeng i samtiden var at graccherne forrykket maktbalansen mellom de ledende slektene; de populære forslagene ville få folkeforsamlingen til å stemme på medlemmer av deres slekt, eller dem de foreslo.\r\n\r\nRekrutteringsproblemene for hæren fortsatte ettersom graccherne ikke hadde lykkes med sine jordreformer og fått økt antallet selveiende bønder. Da gikk Marius til det skritt å se bort fra gjeldende formuesgrenser for militærtjeneste, og slapp eiendomsløse inn i hæren. Dette skapte en ny situasjon der hærfører og soldater ble nærmere knyttet sammen, en forutsetning for borgerkrigstiden som fulgte. Med en nyorganisert hær nedkjempet Marius numiderkongen Jugurtha i 106.\r\n\r\nDa de germanske folkene kjent som kimbrerne og teutonene marsjerte gjennom Gallia og slo romerne ved Arausio i 105, var det på ny en reell fare for at en stor hær fra nord skulle angripe Italia og Roma. Marius ble igjen påkalt og innehadde konsulatet gjentatte ganger. Han lykkes med å avverge germanerfaren ved Aquae Sextiae i 102 og Vercellae i 101.\r\n\r\nForbundsfellene i Italia var misnøyde med at romerske borgere ble favorisert i hæren, ved fordeling av imperieinntektene og ved forpaktningen av statsjorda. Deres krav om full borgerrett var vanskelig å imøtekomme siden et slikt lovforslag kunne forrykke maktbalansen mellom de ledende slekter i Roma. Forbundsfellene gikk til slutt til krig i år 90. Romerne vant krigen, men gav forbundsfellene borgerrett likevel, slik at deres politiske innflytelse ble begrenset. 80-årene ble preget av blodige oppgjør mellom Marius og Sulla. Sulla gikk til slutt seirende ut, og styrte som diktator fra 82 til 79. Han straffet sine motstandere hardt, og fremmet en rekke lover og forordninger med sikte på å styrke senatet på bekostning av folkeforsamlingene og riddere. Da dette var gjennomført, trakk han seg tilbake.\r\n\r\nBorgerkrigstidens annen fase er preget av navn som Pompeius, Crassus, Caesar og Cicero. Pompeius hadde hjulpet Sulla til makten og nedkjempet Sertorius og marianernes siste maktbase i Spania. Sammen med Crassus slo han ned Spartacus-opprøret, den farlige slaveoppstanden i Italia 73–71. Som konsuler i år 70 opphevet imidlertid Pompeius og Crassus mesteparten av Sullas lovgivning, som skulle sikre senatet mot egenrådige aristokrater. De følgende årene ble preget av oppgjøret med sjørøverne (67) og kampene mot Mithradates av Pontos. Pompeius ordnet forholdene i Østen etter sitt eget hode, med et belte av nye provinser og klientkongedømmer. Da senatet nektet å ratifisere hans disposisjoner, var veien åpen for det såkalte 1. triumvirat i år 60, en privat avtale mellom Pompeius, Crassus og Caesar, som førte til at Pompeius\' forordninger ble godkjent da Caesar var konsul i år 59.\r\n\r\nSom stattholder i de galliske provinser erobret Caesar i løpet av 50-årene hele Gallia. Forholdet mellom triumvirene skrantet og Crassus falt i slaget ved Carrhae mot partherne i 53. Da Caesar krysset Rubicon, grenseelven til sin provins, og gikk med sine soldater mot Roma, var en ny borgerkrig et faktum. Senatet gjorde Pompeius til dets hærfører, men han vegret å møte Caesar i Italia og satte over til Hellas der det var stående, trente tropper. Pompeius tapte likevel slaget ved Farsalos i 48, og ble drept i Egypt kort etter. Etter flere slag stod Caesar som den endelige seierherre og lot seg utnevne til diktator i 46.\r\n\r\nCaesar ble myrdet 15. mars år 44. Han satt altså ved makten i kort tid, og siden nesten hele hans karriere var preget av krig eller forberedelser til krig, er det ikke lett å bedømme hans sivile planer for riket. Han fikk gjennomført en kalenderreform, den julianske kalender, initierte omfattende kolonigrunnleggelser i provinsene, og omorganiserte lokalstyret i Italia.\r\n\r\nCaesars mordere, med Brutus og Cassius i spissen, trodde at republikken skulle gjenoppstå etter Caesars død. Men de manglet en skikkelig plan og det kan se ut som om tiden var løpt fra den gamle forfatningen. Det ble raskt strid mellom Caesarmorderne og -tilhengerne. I år 43 dannet Caesars nærmeste medarbeider Marcus Antonius, hans arving og ætling Octavian og diktatorens nestkommanderende Lepidus det 2. triumvirat. De nedkjempet Caesarmorderne ved Filippi i 42, men vendte seg snart mot hverandre. Etter at Lepidus var utmanøvrert, vant Octavian den endelige seier over Antonius og Kleopatra ved slaget ved Actium i år 31.'),
(5, 'Bystaten Roma vokste ut fra bosetninger rundt et vadested ved elva Tiberen, som var et krysspunkt for trafikk og handel. Ifølge arkeologiske undersøkelser skal landsbyen Roma ha blitt dannet på Palatinhøyden en gang i det 9. århundre f.Kr., av medlemmer fra de sentrale italienske stammene, latinerne og sabinerne. Etruskerne, som tidligere holdt til i Etruria i nord, ser ut til å ha tilordnet seg politisk kontroll i områdene rundt Roma sent i det 7. århundre f.Kr.. Etruskerne mistet imidlertid kontrollen i det 6. århundre f.Kr., og de opprinnelige stammene, latinerne og sabinerne, gjenopprettet sin regjering og dannet en republikk med mye sterkere kontroll over ledere som ønsket å utøve makt.\r\n\r\nIfølge romerske legender ble Roma grunnlagt 21. april, 753 f.Kr., av tvillingene Romulus og Remus, som nedstammet fra den trojanske prinsen Aineias. Romulus, som navnet Roma stammer fra, drepte sin bror Remus i en krangel der den nye byen skulle være, og ble den første av i alt syv konger av Roma.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(55) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Privilige` varchar(55) NOT NULL,
  `Created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `UserID` (`UserID`),
  UNIQUE KEY `Username` (`Username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Privilige`, `Created`) VALUES
(1, 'admin', 'admin', 'admin', '2020-02-06 17:14:13'),
(2, 'test', '123', 'default', '2020-02-07 15:00:54');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`CategoryID`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`ParentID`) REFERENCES `categories` (`CategoryID`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `revisions`
--
ALTER TABLE `revisions`
  ADD CONSTRAINT `revisions_ibfk_2` FOREIGN KEY (`TextID`) REFERENCES `text` (`TextID`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `revisions_ibfk_3` FOREIGN KEY (`ArticleID`) REFERENCES `articles` (`ArticleID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `revisions_ibfk_4` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `revisions_ibfk_5` FOREIGN KEY (`mediaID`) REFERENCES `media` (`MediaID`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
