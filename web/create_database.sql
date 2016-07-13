CREATE TABLE IF NOT EXISTS data (
  id int(11) NOT NULL AUTO_INCREMENT,
  ibeacon_major_number int(11) NOT NULL,
  ibeacon_minor_number int(11) NOT NULL,
  latitude double NOT NULL,
  longitude double NOT NULL,
  time_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
  rssi double NOT NULL,
  session_number int(11) NOT NULL,
  test_number int(11) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS session (
  session_number int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (session_number)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS test (
  test_number int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (test_number)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;