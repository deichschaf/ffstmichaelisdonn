import React from 'react';
import { Col, Row } from 'react-bootstrap';
import PageHeadline from '../../../component/atoms/PageHeadline';
import ErrorBoundary from '../../../component/organisms/errorboundary';
import { AnwesenheitOverviewProps } from '../../../props/props';
import { Link } from 'react-router-dom';

const AnwesenheitOverview: React.FC<React.PropsWithChildren<AnwesenheitOverviewProps>> = (
  props: AnwesenheitOverviewProps
): JSX.Element => (
  <ErrorBoundary>
    <Row className="">
      <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
        <PageHeadline label="Anwesenheit" />
      </Col>
    </Row>
    <Row className="protokoll_overview">
      <Col xxl={6} xl={6} lg={6} md={6} sm={6} xs={6} className="protokoll_button einsatz">
        <Link to="/app/anwesenheit/einsatz">Einsatz</Link>
      </Col>
      <Col xxl={6} xl={6} lg={6} md={6} sm={6} xs={6} className="protokoll_button uebung">
        <Link to="/app/anwesenheit/uebung">Dienstabend</Link>
      </Col>
    </Row>
    <Row className="protokoll_overview">
      <Col xxl={6} xl={6} lg={6} md={6} sm={6} xs={6} className="protokoll_button absicherung">
        <Link to="/app/anwesenheit/absicherung">Verkehrsabsicherung</Link>
      </Col>
      <Col xxl={6} xl={6} lg={6} md={6} sm={6} xs={6} className="protokoll_button hydrantenpflege">
        <Link to="/app/anwesenheit/hydrantenpflege">Hydrantenpflege</Link>
      </Col>
    </Row>
  </ErrorBoundary>
);

export default AnwesenheitOverview;
