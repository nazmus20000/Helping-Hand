-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2015 at 05:24 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `helphand`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE IF NOT EXISTS `appointment` (
  `a_id` int(100) NOT NULL AUTO_INCREMENT,
  `v_id` int(100) NOT NULL,
  `serial` int(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`a_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`a_id`, `v_id`, `serial`, `email`) VALUES
(31, 26, 1, 'n@g.com'),
(32, 26, 2, 's@g.com');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `c_id` int(255) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `med_id` int(255) NOT NULL,
  `quan` int(255) NOT NULL,
  `date` varchar(100) NOT NULL,
  `ctgry` varchar(100) NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE IF NOT EXISTS `doctors` (
  `d_id` int(100) NOT NULL AUTO_INCREMENT,
  `u_id` int(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `qualification` varchar(1000) NOT NULL,
  `designation` varchar(200) NOT NULL,
  `expertise` varchar(200) NOT NULL,
  `organization` varchar(1000) NOT NULL,
  `chamber` varchar(1000) NOT NULL,
  `location` varchar(400) NOT NULL,
  `phn` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`d_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`d_id`, `u_id`, `name`, `qualification`, `designation`, `expertise`, `organization`, `chamber`, `location`, `phn`, `email`) VALUES
(1, 1, 'Professor Dr. A. B. M. Yunus', 'MBBS (India), MPhil Path (Hons), FCPS (Hematology)', 'Professor', 'Hematology', 'Bangabandhu Sheikh Mujib Medical University', 'Green View Clinic', '25/3, Green Road, Dhaka - 1205', '+880-2-8610313, 9661410', 'n@g.com'),
(2, 13, 'Professor Dr. A.A. Quoreshi', 'MBBS, PGT ( USA )', 'Consultant, Chief & Managing Director', 'Psychiatry', 'MUKTI ( Manashik & Madakashakti Niramoy Kendra Ltd. )', 'MUKTI ( Manashik & Madakashakti Niramoy Kendra Ltd. )', 'House # 2, Road # 49, Gulshan # 2, Dhaka - 1212, Bangladesh', '+880 2 9896165, 9883991, 8814562', 'q@g.com');

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE IF NOT EXISTS `medicines` (
  `med_id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) NOT NULL,
  `type` varchar(1000) NOT NULL,
  `ctgry` varchar(1000) NOT NULL,
  `des` varchar(10000) NOT NULL,
  `quan` int(255) NOT NULL,
  `stat` varchar(100) NOT NULL,
  `price` int(255) NOT NULL,
  `pic` varchar(10000) NOT NULL,
  PRIMARY KEY (`med_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`med_id`, `name`, `type`, `ctgry`, `des`, `quan`, `stat`, `price`, `pic`) VALUES
(1, 'Axodin(Fexofenadine)', 'Tablet/Suspension', 'Allergic Disorders', 'Axodin is a preparation of Fexofenadine, a pharmacologically active metabolite of Terfenadine, is a non-sedating antihistamine with selective peripheral H1 receptor antagonist activity. Axodin is indicated for the relief of symptoms associated with allergic rhinitis and allergic skin conditions e.g. chronic urticaria.\n', 100, 'Available', 100, 'Axodin.jpg'),
(2, 'Dextromethorphan', 'Syrup', 'Cough & Cold', 'Dextromethorphan is an antitussive and the d-isomer of codeine analogue of levorphanol. It acts as a cough suppressant. It shows depressant action the cough centre of the brain. It is indicated for non productive cough.', 100, 'Available', 50, 'Dextromethorphan.jpg'),
(3, 'Azithrocin(Azithromycin)', '2mg/ml IV infusion, 500 mg Tablet, capsule & suspension', 'Anti-infectives', 'Azithrocin contains Azithromycin U.S.P. It is an azalide antibiotics active against Gram-positive and gram negative organisms. Azithrocin (Azithromycin) in indicated for infections caused by susceptible organisms; In lower respiratory tract infections including bronchitis and pneumonia, skin and soft tissue infections, otitis media and in upper respiratory tract infections including sinusitis, pharyngitis and tonsillitis. In sexually transmitted disease in men and women Azithrocin (Azithromycin) is indicated in the treatment of uncomplicated genital infections due to Chlamydia trachomatis. Azithrocin has very simple once daily dosage schedule for 3 days only, which is very convenient for the patients.', 100, 'Available', 50, 'Azithrocin.jpg'),
(4, 'Filmet(Metronidazole)', 'Tablet, Suspension, IV Infusion', 'Anti-infectives', 'Filmet is the brand of Metronidazole film coated tablets, lemon flavored suspension and iIntravenous infusion. The special film coating tablet is to mask the characteristic bitterness of. Metronidazole which may sometimes cause nausea. Filmet has antiprotozoal action and effective against Trichomonas vaginalis, Entamoeba histolytica, Giardia intestinalis. Filmet is indicated in anaerobic bacterial infections like acute ulcerative gingivitis and anaerobic vaginosis. Filmet is also indicated in Intra abdominal infections, Skin and skin structure infections, Bacterial septicemia, Bone and Joint infections, Central nervous system infections, Lower respiratory tract infections and Endocarditis.', 100, 'Available', 33, 'Filmet.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `n_id` int(100) NOT NULL AUTO_INCREMENT,
  `send` varchar(100) NOT NULL,
  `rec` varchar(100) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `date` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`n_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`n_id`, `send`, `rec`, `message`, `date`, `status`) VALUES
(13, 'n@g.com', 's@g.com', 'Professor Dr. A. B. M. Yunus schedule has been changed.Please see the appointment list for the perticular change.Sorry for the inconvenience.', '09/05/2015 10:54:51', ''),
(14, 'n@g.com', 's@g.com', 'Professor Dr. A. B. M. Yunus will not be available at Sunday 11:00 AM this week.Please try another visiting hour.Sorry for the inconvenience.', '09/05/2015 10:56:33', ''),
(15, 'n@g.com', 'q@g.com', 'Professor Dr. A. B. M. Yunus will not be available at Sunday 11:00 AM this week.Please try another visiting hour.Sorry for the inconvenience.', '09/05/2015 10:56:33', 'Seen'),
(16, 'n@g.com', 'q@g.com', 'Professor Dr. A. B. M. Yunus schedule has been changed.Please see the appointment list for the perticular change.Sorry for the inconvenience.', '09/05/2015 11:01:25', 'Seen'),
(17, 'n@g.com', 's@g.com', 'Professor Dr. A. B. M. Yunus schedule has been changed.Please see the appointment list for the perticular change.Sorry for the inconvenience.', '09/05/2015 11:01:25', ''),
(18, 'n@g.com', 'q@g.com', 'Professor Dr. A. B. M. Yunus will not be available at Sunday 03:00 AM this week.Please try another visiting hour.Sorry for the inconvenience.', '09/05/2015 11:04:54', 'Seen'),
(19, 'n@g.com', 's@g.com', 'Professor Dr. A. B. M. Yunus will not be available at Sunday 03:00 AM this week.Please try another visiting hour.Sorry for the inconvenience.', '09/05/2015 11:04:54', ''),
(20, 'n@g.com', 'q@g.com', 'Professor Dr. A. B. M. Yunus will not be available at Monday 10:00 AM this week.Please try another visiting hour.Sorry for the inconvenience.', '09/05/2015 11:04:54', 'Seen'),
(21, 'n@g.com', 's@g.com', 'Professor Dr. A. B. M. Yunus will not be available at Monday 10:00 AM this week.Please try another visiting hour.Sorry for the inconvenience.', '09/05/2015 11:04:54', '');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `p_id` int(100) NOT NULL AUTO_INCREMENT,
  `u_id` int(100) NOT NULL,
  `fstname` varchar(1000) NOT NULL,
  `lstname` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `credit_card` int(100) NOT NULL,
  `phn` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `pic` varchar(100) NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`p_id`, `u_id`, `fstname`, `lstname`, `gender`, `credit_card`, `phn`, `address`, `pic`) VALUES
(1, 1, 'Professor Dr. A. B. M.', 'Yunus', 'Male', 7658899, '', '', ''),
(2, 13, 'Professor Dr. A.A.', 'Quoreshi', 'Male', 343455, '', '', ''),
(4, 12, 'Shahed', 'Ahmed', 'Male', 131232134, '123124124142', '141-72,85th road,apt# 6-b,\r\nbriarwood', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(100) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `type` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `photo`, `type`) VALUES
(1, 'Yunus', 'n@g.com', '1234', '', 'doctor'),
(12, 'shahed', 's@g.com', '123', '', 'member'),
(13, 'Quoreshi', 'q@g.com', '1234', '', 'doctor');

-- --------------------------------------------------------

--
-- Table structure for table `visiting_hours`
--

CREATE TABLE IF NOT EXISTS `visiting_hours` (
  `v_id` int(100) NOT NULL AUTO_INCREMENT,
  `d_id` int(100) NOT NULL,
  `s_id` int(100) NOT NULL,
  `day` varchar(100) NOT NULL,
  `s_time` varchar(100) NOT NULL,
  `e_time` varchar(100) NOT NULL,
  `s_st` varchar(20) NOT NULL,
  `e_st` varchar(20) NOT NULL,
  `c_limit` int(100) NOT NULL,
  PRIMARY KEY (`v_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `visiting_hours`
--

INSERT INTO `visiting_hours` (`v_id`, `d_id`, `s_id`, `day`, `s_time`, `e_time`, `s_st`, `e_st`, `c_limit`) VALUES
(26, 2, 2, 'Saturday', '10:00', '12:00', 'AM', 'PM', 10),
(27, 2, 5, 'Monday', '08:00', '09:00', 'AM', 'AM', 8);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
