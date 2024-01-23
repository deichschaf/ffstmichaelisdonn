import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { PaulinchenTdbKProps } from '../../../../props/props';
import SVGIcon from '../../../atoms/SVGIcon';
import ErrorBoundary from '../../../organisms/errorboundary';
import GridBox from '../../GridBox';

const PaulinchenTdbK: React.FC<React.PropsWithChildren<PaulinchenTdbKProps>> = (
  props: PaulinchenTdbKProps
): JSX.Element => {
  const link = 'https://www.paulinchen.de';
  const link_dfv = 'https://www.dfv.org';
  return (
    <ErrorBoundary>
      <GridBox lable="7. Dezember - „Tag des brandverletzten Kindes“">
        <Row>
          <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={12}>
            <a href={link} target="_blank" rel="noreferrer">
              <SVGIcon svg="PaulinchenEV" alt="Paulinchen e.V." className="picture" />
            </a>
          </Col>
          <Col xxl={10} xl={10} lg={10} md={10} sm={10} xs={12}>
            <p className="text">
              Der „Tag des brandverletzten Kindes“ am 7. Dezember steht in diesem Jahr unter dem
              Motto „Brandheiß! Brandgefährlich! Brandverletzt!“. Jedes Jahr müssen allein in
              Deutschland mehr als 30.000 Kinder unter 15 Jahren mit Verbrennungen und Verbrühungen
              ärztlich versorgt werden, rund 7.000 Kinder verletzen sich so schwer, dass sie im
              Krankenhaus behandelt werden müssen. Daher richtet{' '}
              <a href={link} target="_blank" rel="noreferrer">
                Paulinchen - Initiative für brandverletzte Kinder e.V.
              </a>{' '}
              in diesem Jahr den Fokus besonders auf brandheiße, brandgefährliche Unfallursachen,
              die zu Brandverletzungen führen. Am „Tag des brandverletzten Kindes“ wird über
              Unfallgefahren aufgeklärt und über die schwerwiegenden Folgen von Verbrennungen und
              Verbrühungen informiert. Das Motto „Brandheiß! Brandgefährlich! Brandverletzt!“ soll
              zeigen, wie schnell ein Unfall passieren kann und Eltern für Unfallursachen
              sensibilisieren. „Vielen Eltern ist nicht bewusst, dass gerade im häuslichen Bereich
              die meisten Unfälle passieren und direkt im kindlichen Umfeld „brandheiße“ Gefahren
              lauern. Die frisch aufgebrühte Tasse Tee, der gerade angezündete Kaminofen oder die
              Kerze, die kurz unbeaufsichtigt war, können innerhalb von Sekunden zu Verbrühungen
              oder Verbrennungen der zarten Kinderhaut führen. Nur wenn Eltern die Gefahren kennen,
              können sie präventive Maßnahmen ergreifen und diese folgenschweren Unfälle
              verhindern“, stellt Susanne Falk, Vorsitzende von
              <a href={link} target="_blank" rel="noreferrer">
                Paulinchen – Initiative für brandverletzte Kinder e. V.
              </a>
              , fest.
            </p>
            <p>
              Quelle:{' '}
              <a href={link_dfv} target="_blank" rel="noreferrer">
                Deutscher Feuerwehrverband
              </a>
            </p>
          </Col>
        </Row>
      </GridBox>
    </ErrorBoundary>
  );
};
export default PaulinchenTdbK;
