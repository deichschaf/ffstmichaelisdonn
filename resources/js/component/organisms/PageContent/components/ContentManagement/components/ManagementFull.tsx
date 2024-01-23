import React from 'react';
import { ManagementFullProps } from '../../../../../../props/props';
import ErrorBoundary from '../../../../errorboundary';
import ManagementFullDetail from './ManagementFullDetail';

const ManagementFull: React.FC<React.PropsWithChildren<ManagementFullProps>> = (
  props: ManagementFullProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  // const keys = [];
  const values = [];
  const { data, funktionIds } = props;

  function checkExists(items) {
    if (funktionIds.includes(items.function_id)) {
      values.push(items as never);
    }
  }
  function buildManagement(items, idx) {
    if (funktionIds.includes(items.function_id) === false) {
      return <></>;
    }
    // const datas = Object.entries(items.data).map(([key, value]) => ({ key, value }));
    const datas = items.data;
    // const datas = Object.keys(items.data).map(key => ({ key, value: items.data[key] }));
    const funktion = datas.funktion_text;
    const firstname = datas.vorname;
    const surname = datas.nachname;
    const grade = datas.dienstgrad;
    const img = datas.bild;
    const images = datas.bilder;
    const { id } = datas;
    return (
      <ErrorBoundary key={idx}>
        <ManagementFullDetail
          id={id}
          firstname={firstname}
          surname={surname}
          function={funktion}
          grade={grade}
          img={img}
          images={images}
        />
      </ErrorBoundary>
    );
  }
  // Object.keys(data).map((key, idx) => keys.push(key as never));
  Object.values(data).map((value, idx) => checkExists(value));
  return <ErrorBoundary>{values.map((item, idx) => buildManagement(item, idx))}</ErrorBoundary>;
};
export default ManagementFull;
