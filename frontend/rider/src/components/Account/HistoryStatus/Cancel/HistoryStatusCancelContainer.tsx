import React from "react";
import { Container, Row, Col } from "react-bootstrap";

import styles from "./HistoryStatusCancelContainer.module.scss";
import Navigation from "../../Navigation";
import HistoryStatusCancelContent from "./HistoryStatusCancelContent";

interface ContainerProps {}

const HistoryStatusContainer: React.FC<ContainerProps> = ({}) => {
  return (
    <Container fluid="xxl">
      <Row className={styles.container}>
        <Col lg={4} className={styles.mobileNav}>
          <div className={styles.navigationContainer}>
            <Navigation />
          </div>
        </Col>
        <Col lg={8}>
          <div className={styles.contentContainer}>
            <HistoryStatusCancelContent />
          </div>
        </Col>
      </Row>
    </Container>
  );
};

export default HistoryStatusContainer;
