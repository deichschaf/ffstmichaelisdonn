import React, { useState } from 'react';
import ButtonFAS from '../component/atoms/Buttons/ButtonFAS';
import FA from '../component/atoms/Icon/FA';
import FAB from '../component/atoms/Icon/FAB';
import FAD from '../component/atoms/Icon/FAD';
import FAL from '../component/atoms/Icon/FAL';
import FAR from '../component/atoms/Icon/FAR';
import FAS from '../component/atoms/Icon/FAS';
import PictureSourcSet from '../component/atoms/Picture/SourceSet';
import { Link } from 'react-router-dom';

function getFA(type) {
  return (
    <span className={type.color}>
      <FA title={type.readable} className={type.icon} />
    </span>
  );
}

function getFAB(type) {
  return (
    <span className={type.color}>
      <FAB title={type.readable} className={type.icon} />
    </span>
  );
}

function getFAD(type) {
  return (
    <span className={type.color}>
      <FAD title={type.readable} className={type.icon} />
    </span>
  );
}

function getFAL(type) {
  return (
    <span className={type.color}>
      <FAL title={type.readable} className={type.icon} />
    </span>
  );
}

function getFAR(type) {
  return (
    <span className={type.color}>
      <FAR title={type.readable} className={type.icon} />
    </span>
  );
}

function getFAS(type) {
  return (
    <span className={type.color}>
      <FAS title={type.readable} className={type.icon} />
    </span>
  );
}

function getFAFallBack() {
  return (
    <span className="todo_type_color_bug">
      <FAS title="Bug" className="bug" />
    </span>
  );
}

export function getTodoType(type_id, props) {
  if (typeof props.todo_type !== 'undefined') {
    for (let i = 0; i < props.todo_type.length; i += 1) {
      if (typeof props.todo_type[i] !== 'undefined') {
        if (props.todo_type[i].id === type_id) {
          if (props.todo_type[i].fa === 'FAS') {
            return getFAS(props.todo_type[i]);
          }
          if (props.todo_type[i].fa === 'FA') {
            return getFA(props.todo_type[i]);
          }
          if (props.todo_type[i].fa === 'FAB') {
            return getFAB(props.todo_type[i]);
          }
          if (props.todo_type[i].fa === 'FAD') {
            return getFAD(props.todo_type[i]);
          }
          if (props.todo_type[i].fa === 'FAL') {
            return getFAL(props.todo_type[i]);
          }
          if (props.todo_type[i].fa === 'FAR') {
            return getFAR(props.todo_type[i]);
          }
        }
      }
    }
    return getFAFallBack();
  }
  return '';
}

export function getGermanMonthName(month) {
  const months = [
    '',
    'Januar',
    'Februar',
    'März',
    'April',
    'Mai',
    'Juni',
    'Juli',
    'August',
    'September',
    'Oktober',
    'November',
    'Dezember',
  ];
  return months[parseInt(month, 10)];
}

export function checkContentTitle(title) {
  if (title !== null && title !== 'null' && title !== '') {
    return <>{title}</>;
  }
  return <></>;
}

export function getDescription(description) {
  if (description !== null && description !== 'null' && description !== '') {
    return (
      <>
        <br />
        <small>{description}</small>
      </>
    );
  }
  return <></>;
}

export function checkToDoArea(id, todo_area) {
  if (typeof todo_area !== 'undefined') {
    for (let i = 0; i < todo_area.length; i += 1) {
      if (todo_area[i].id === id) {
        return todo_area[i].name;
      }
    }
  }
  return '';
}

export function getContent(title, description) {
  const content = title;
  const contentDescription = getDescription(description);

  return (
    <>
      {content}
      {contentDescription}
    </>
  );
}

export function checkStatusId(status_id, todo_status_id) {
  if (parseInt(status_id, 10) === parseInt(todo_status_id, 10)) {
    return true;
  }
  return false;
}

export function deleteLink(props, item) {
  return (
    <Link to={`${props.form_delete_url}/${item.id}`} title="">
      <FAS title="löschen" className="trash red" />
    </Link>
  );
}

export function deletePageLink(id, path) {
  return (
    <Link to={`${path}/${id}`} title="">
      <FAS title="löschen" className="trash red" />
    </Link>
  );
}

export function editPageLink(id, path) {
  return (
    <Link to={`${path}/${id}`} title="">
      <FAS title="ändern" className="edit" />
    </Link>
  );
}

export function editHeadlinePageLink(id, path) {
  return (
    <Link to={`${path}/${id}`} title="">
      <FAS title="ändern" className="edit" />
    </Link>
  );
}

export function checkUrlExists(id, type) {
  // eslint-disable-next-line react-hooks/rules-of-hooks
  const [getResponse, setResponse] = useState('');
  fetch(`${GlobalVars.JSDomain()}/api/${type}/check/${id}`)
    .then(response => response.json())
    .then(data => setResponse(data));
  return getResponse;
}

export function showImgActive(item, jsdomain) {
  const path = jsdomain + '/api/links/check/';
  return <PictureSourcSet img={item.id} path={path} />;
}

export function checkIsBrocken(bool) {
  if (bool === false || bool === 0) {
    return <FAS title="defekt" className="lightblub red" />;
  }
  if (bool === true || bool === 1) {
    return <FAS title="funktioniert" className="lightblub green" />;
  }
  return <FAS title="nicht getestet" className="lightblub grey" />;
}

export function isActive(active) {
  const bool = parseInt(active, 10);
  if (bool === 1 || bool === '1' || bool === true) {
    return <FAR className="eye green" />;
  }
  return <FAR className="eye-slash red" />;
}

export function isActiveCheck(active) {
  const bool = parseInt(active, 10);
  if (bool === 1 || bool === '1' || bool === true) {
    return <FAS className="check green" />;
  }
  return <></>;
}

export function pdfLink(props, item) {
  return (
    <a href={`${props.form_print_url}/${item.id}`} target="_blank" title="" rel="noreferrer">
      <FAS title="drucken" className="file-pdf" />
    </a>
  );
}

export function viewLink(props, item) {
  return (
    <Link to={`${props.form_view_url}/${item.id}`} title="">
      <FAS title="anschauen" className="search" />
    </Link>
  );
}

export function editLink(props, item) {
  return (
    <Link to={`${props.form_edit_url}/${item.id}`} title="">
      <FAS title="ändern" className="edit" />
    </Link>
  );
}

export function showModal(id) {
  if (typeof id !== 'undefined') {
    if (id !== null) {
      console.log(id);
      // document.getElementById(id).style.display = 'block';
    }
  }
}

export function editorModal(props, item, parent) {
  return (
    <ButtonFAS
      title="edit"
      type="button"
      data-toggle="modal"
      data-target={`#editModal${item.id}`}
      onClick={e => parent.openEditModal(item)}
      FAclassName="edit"
      className="ButtonFA"
    />
  );
}

export function editModalLink(props, item) {
  return (
    <ButtonFAS
      title="edit"
      type="button"
      data-toggle="modal"
      data-target={`#editModal${item.id}`}
      onClick={e => showModal(`#editModal${item.id}`)}
      FAclassName="edit"
      className="ButtonFA"
    />
  );
}

export function copyLink(props, item) {
  return (
    <Link to={`${props.form_copy_url}/${item.id}`} title="">
      <FAS title="kopieren" className="copy" />
    </Link>
  );
}

export function checkParentId(id) {
  if (id === 'null' || id === null) {
    return '';
  }
  return id;
}

export function checkImage(bild) {
  if (bild !== '' && bild !== 'NULL' && bild !== null) {
    return <FAR className="file-image" />;
  }
  return '';
}

export function checkCopyId(id) {
  if (id === 'null' || id === null) {
    return '';
  }
  return id;
}
