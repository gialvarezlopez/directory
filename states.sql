/*
MySQL Data Transfer
Source Host: localhost
Source Database: fresnojazz2
Target Host: localhost
Target Database: fresnojazz2
Date: 9/18/2009 7:38:14 AM
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for states
-- ----------------------------
DROP TABLE IF EXISTS `states`;
CREATE TABLE `states` (
  `state` varchar(22) NOT NULL,
  `state_code` char(2) NOT NULL,
  `lat` varchar(50) NOT NULL,
  `lng` varchar(50) NOT NULL,
  PRIMARY KEY (`state_code`)
) TYPE=MyISAM;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `states` VALUES ('Alaska', 'AK','61.370716','-152.404419');
INSERT INTO `states` VALUES ('Alabama', 'AL','32.806671','-86.791130');
INSERT INTO `states` VALUES ('Arkansas', 'AR','34.969704','-92.373123');
INSERT INTO `states` VALUES ('Arizona', 'AZ','33.729759','-111.431221');
INSERT INTO `states` VALUES ('California', 'CA','36.116203','-119.681564');
INSERT INTO `states` VALUES ('Colorado', 'CO','39.059811','-105.311104');
INSERT INTO `states` VALUES ('Connecticut', 'CT','41.597782','-72.755371');
INSERT INTO `states` VALUES ('District of Columbia', 'DC','38.897438','-77.026817');
INSERT INTO `states` VALUES ('Delaware', 'DE','38.897438','-77.026817');
INSERT INTO `states` VALUES ('Florida', 'FL','27.766279','-81.686783');
INSERT INTO `states` VALUES ('Georgia', 'GA','33.040619','-83.643074');
INSERT INTO `states` VALUES ('Hawaii', 'HI','21.094318','-157.498337');
INSERT INTO `states` VALUES ('Iowa', 'IA','21.094318','-157.498337');
INSERT INTO `states` VALUES ('Idaho', 'ID','44.240459','-114.478828');
INSERT INTO `states` VALUES ('Illinois', 'IL','40.349457','-88.986137');
INSERT INTO `states` VALUES ('Indiana', 'IN','39.849426','-86.258278');
INSERT INTO `states` VALUES ('Kansas', 'KS','38.526600','-96.726486');
INSERT INTO `states` VALUES ('Kentucky', 'KY','37.668140','-84.670067');
INSERT INTO `states` VALUES ('Louisiana', 'LA','31.169546','-91.867805');
INSERT INTO `states` VALUES ('Massachusetts', 'MA','42.230171','-71.530106');
INSERT INTO `states` VALUES ('Maryland', 'MD','39.063946','-76.802101');
INSERT INTO `states` VALUES ('Maine', 'ME','44.693947','-69.381927');
INSERT INTO `states` VALUES ('Michigan', 'MI','43.326618','-84.536095');
INSERT INTO `states` VALUES ('Minnesota', 'MN','45.694454','-93.900192');
INSERT INTO `states` VALUES ('Missouri', 'MO','38.456085','-92.288368');
INSERT INTO `states` VALUES ('Mississippi', 'MS','32.741646','-89.678696');
INSERT INTO `states` VALUES ('Montana', 'MT','46.921925','-110.454353');
INSERT INTO `states` VALUES ('North Carolina', 'NC','35.630066','-79.806419');
INSERT INTO `states` VALUES ('North Dakota', 'ND','47.528912','-99.784012');
INSERT INTO `states` VALUES ('Nebraska', 'NE','41.125370','-98.268082');
INSERT INTO `states` VALUES ('New Hampshire', 'NH','43.452492','-71.563896');
INSERT INTO `states` VALUES ('New Jersey', 'NJ','40.298904','-74.521011');
INSERT INTO `states` VALUES ('New Mexico', 'NM','34.840515','-106.248482');
INSERT INTO `states` VALUES ('Nevada', 'NV','38.313515','-117.055374');
INSERT INTO `states` VALUES ('New York', 'NY','42.165726','-74.948051');
INSERT INTO `states` VALUES ('Ohio', 'OH','40.388783','-82.764915');
INSERT INTO `states` VALUES ('Oklahoma', 'OK','35.565342','-96.928917');
INSERT INTO `states` VALUES ('Oregon', 'OR','44.572021','-122.070938');
INSERT INTO `states` VALUES ('Pennsylvania', 'PA','40.590752','-77.209755');
INSERT INTO `states` VALUES ('Rhode Island', 'RI','41.680893','-71.511780');
INSERT INTO `states` VALUES ('South Carolina', 'SC','33.856892','-80.945007');
INSERT INTO `states` VALUES ('South Dakota', 'SD','44.299782','-99.438828');
INSERT INTO `states` VALUES ('Tennessee', 'TN','35.747845','-86.692345');
INSERT INTO `states` VALUES ('Texas', 'TX','31.054487','-97.563461');
INSERT INTO `states` VALUES ('Utah', 'UT','40.150032','-111.862434');
INSERT INTO `states` VALUES ('Virginia', 'VA','37.769337','-78.169968');
INSERT INTO `states` VALUES ('Vermont', 'VT','44.045876','-72.710686');
INSERT INTO `states` VALUES ('Washington', 'WA','47.400902','-121.490494');
INSERT INTO `states` VALUES ('Wisconsin', 'WI','44.268543','-89.616508');
INSERT INTO `states` VALUES ('West Virginia', 'WV','38.491226','80.954453');
INSERT INTO `states` VALUES ('Wyoming', 'WY','42.755966','-107.302490');
