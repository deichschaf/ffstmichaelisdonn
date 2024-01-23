import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { WidgetLoaderProps } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';
import SVGIcon from '../../SVGIcon';
import H4 from '../../Typography/H4';

const NinaAppInfo: React.FC<React.PropsWithChildren<WidgetLoaderProps>> = (
  props: WidgetLoaderProps,
): JSX.Element => (
  <ErrorBoundary>
    <Row>
      <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
        <H4 className="text-center" label="Sofort und Überall informiert" />
      </Col>
    </Row>
    <Row>
      <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
        <p>
          Mit der Notfall-Informations- und Nachrichten-App des Bundes, kurz Warn-App NINA, sind Sie
          bei Gefahrensituationen sofort und überall informiert.
        </p>
      </Col>
    </Row>
    <Row>
      <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
        <SVGIcon svg="NinaBBK" alt="Warn-App Nina" className="picture" />
      </Col>
    </Row>
    <Row>
      <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
        &nbsp;
      </Col>
    </Row>
    <Row>
      <Col xxl={6} xl={6} lg={6} md={6} sm={6} xs={6}>
        <a
          href="https://play.google.com/store/apps/details?id=de.materna.bbk.mobile.app"
          target="_blank"
          rel="noreferrer"
        >
          <SVGIcon
            svg="GoogleStore"
            alt="NINA Warn-APP - Jetzt bei Google Play"
            className="picture"
          />
        </a>
      </Col>
      <Col xxl={6} xl={6} lg={6} md={6} sm={6} xs={6}>
        <a href="https://apps.apple.com/de/app/nina/id949360949" target="_blank" rel="noreferrer">
          <SVGIcon svg="AppleStore" alt="NINA Warn-APP - Laden im App Store" className="picture" />
        </a>
      </Col>
    </Row>
  </ErrorBoundary>
);
export default NinaAppInfo;
