import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { ReadyForUseProps } from '../../../props/props';
import GridSimple from '../../molecules/GridSimple';
import ErrorBoundary from '../../organisms/errorboundary';
import H2 from '../Typography/H2';
import H3 from '../Typography/H3';

const ReadyForUse: React.FC<React.PropsWithChildren<ReadyForUseProps>> = (
  props: ReadyForUseProps,
): JSX.Element => (
  <ErrorBoundary>
    <GridSimple>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <H2 className="text-center" label="24/7/365 Einsatzbereit, für Ihre Sicherheit!" />
        </Col>
      </Row>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <H3 className="text-center" label="Bedeutung einer Freiwilligen Feuerwehr" />
        </Col>
      </Row>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <p className="text">
            Eine Freiwillige Feuerwehr ist eine Feuerwehr, welche sich aus ehrenamtlichen
            Mitgliedern zusammensetzt. Im Alarmfall werden diese ehrenamtlichen Kräfte mit einem
            Pager alarmiert und begeben sich schnellstmöglich ans Feuerwehrgerätehaus.
          </p>
        </Col>
      </Row>
    </GridSimple>
  </ErrorBoundary>
);
export default ReadyForUse;
