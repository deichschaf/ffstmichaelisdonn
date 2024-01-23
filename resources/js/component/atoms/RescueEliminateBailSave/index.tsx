import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { RescueEliminateBailSaveProps } from '../../../props/props';
import GridSimple from '../../molecules/GridSimple';
import ErrorBoundary from '../../organisms/errorboundary';
import H2 from '../Typography/H2';
import H3 from '../Typography/H3';

const RescueEliminateBailSave: React.FC<React.PropsWithChildren<RescueEliminateBailSaveProps>> = (
  props: RescueEliminateBailSaveProps,
): JSX.Element => (
  <ErrorBoundary>
    <GridSimple>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <H2 className="text-center" label="Wer wir sind, was wir tun" />
        </Col>
      </Row>
      <Row>
        <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
          <H3 className="text-center" label="Retten" />
          <p className="text-center">
            Das Retten ist die Abwendung einer Lebensgefahr von Menschen durch Sofortmaßnahmen
            (Erste Hilfe), die der Erhaltung oder Wiederherstellung von Atmung, Kreislauf oder
            Herztätigkeit dienen und/oder Befreien aus einer Zwangslage durch technische
            Rettungsmaßnahmen. Tätigkeitsfelder hierfür sind z. B. Brände, Überschwemmungen oder
            Verkehrsunfälle.
          </p>
        </Col>
        <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
          <H3 className="text-center" label="Löschen" />
          <p className="text-center">
            Das Löschen ist die älteste Aufgabe der Feuerwehr. Bei diesem so genannten abwehrenden
            Brandschutz werden unterschiedlichste Brände mit Hilfe spezieller Ausrüstung bekämpft.
            Aufgrund der zunehmenden Aufgabenvielfalt der Feuerwehr nehmen die technischen
            Hilfeleistungen stark zu – die Feuerwehr entwickelt sich zur Hilfeleistungsorganisation.
          </p>
        </Col>
        <Col xxl={4} xl={4} lg={4} md={4} sm={12} xs={12}>
          <H3 className="text-center" label="Bergen & Schützen" />
          <p className="text-center">
            Vorbeugende Maßnahmen (das Schützen) beinhalten im Wesentlichen Elemente des
            vorbeugenden Brandschutzes. Besonders in Industrienationen wird dem Betriebsbrandschutz
            immer mehr Augenmerk geschenkt, sei es durch eigene betriebliche oder durch öffentliche
            Feuerwehren.
          </p>
        </Col>
      </Row>
    </GridSimple>
  </ErrorBoundary>
);
export default RescueEliminateBailSave;
